<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\DocumentArchive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Admin extends Controller
{
    //
    public function insertDocument(Request $request)
    {
        //verify if get
        if ($request->isMethod('post')) {
            $registerValidated = $request->validate([
                'fundo' => 'required',
                'grupo' => 'required',
                'localizacao' => 'required',
                'emissor' => 'required',
                'destinatario' => 'required',
                'quantidade' => 'required',
                'identificacao' => 'required',
                'data_producao' => 'required'
            ]);
            try {
                //verify if dir exists
                if (!is_dir(Config::get('app.app_files_path'))) {
                    mkdir(Config::get('app.app_files_path'), 0777, true);
                }
                $created = DB::table('documentos')->insert([
                    'fundo' => $request->fundo,
                    'grupo' => $request->grupo,
                    'num_ordem' => $request->num_ordem,
                    'codigo_ttd' => $request->codTTD,
                    'data_producao' => $request->data_producao,
                    'localizacao' => $request->localizacao,
                    'emissor' => $request->emissor,
                    'funcao_emissor' => $request->funcao_emissor,
                    'destinatario' => $request->destinatario,
                    'funcao_destinatario' => $request->funcao_destinatario,
                    'formato_suporte' => $request->formato_suporte,
                    'quantidade' => $request->quantidade,
                    'identificacao' => $request->identificacao,
                    'observacao' => $request->observacao,
                    'usuario' => auth()->user() !== null ? auth()->user()->nome : null,
                ]);
                if (!$created) {
                    return redirect()->route('documentAdd')->with('error', 'Erro ao inserir documento');
                }
                $documentId = DB::table('documentos')->max('id_documento');
                if ($request->hasFile('files')) {
                    $files = $request->file('files');
                    $formatedLocalizacao = "\\Localização " . str_replace('/', '.', $request->localizacao);
                    $fullDir = Config::get('app.app_files_path') . $formatedLocalizacao;
                    if (!Storage::disk('externo')->exists($fullDir)) {
                        $dirCreated = Storage::disk('externo')->makeDirectory($fullDir);
                        if (!$dirCreated) {
                            return redirect()->route('documentAdd', ['id' => $request->id])->with('error', 'Erro ao criar diretório para armazenar arquivos');
                        }
                    }
                    foreach ($files as $file) {
                        $filename = "\\" . $file->getClientOriginalName();
                        $file->storeAs($fullDir, $filename, 'externo');
                        DocumentArchive::insert([
                            'path' => $formatedLocalizacao . $filename,
                            'documentId' => $documentId
                        ]);
                    }
                }
            } catch (\Exception $e) {
                return redirect()->route('documentAdd')->with('error', $e->getMessage());
            }
            return redirect()->route('documentAdd')->with('success', 'Documento inserido com sucesso');
//            return redirect()->route('documentAdd', ['id' => $documentId])->with('success', 'Documento inserido com sucesso');
        } else {
            $id = $request->id;
            if ($id) {
                $document = DB::table('documentos')->where('id_documento', $id)->first();
                $files = DocumentArchive::where('documentId', $id)->get();
                return view('arquivoVirtual.insertDocument', ['documentId' => $id, 'document' => $document, 'files' => $files]);
            }
            return view('arquivoVirtual.insertDocument', []);
        }

    }

    public function editDocument(Request $request)
    {
        $registerValidated = $request->validate([
            'id' => 'required',
            'fundo' => 'required',
            'grupo' => 'required',
//            'num_ordem' => 'required',
//            'codigo_ttd' => 'required',
            'localizacao' => 'required',
            'emissor' => 'required',
//            'funcao_emissor' => 'required',
            'destinatario' => 'required',
//            'funcao_destinatario' => 'required',
//            'formato_suporte' => 'required',
            'quantidade' => 'required',
            'identificacao' => 'required',
//            'observacao' => 'required',
            'data_producao' => 'required'
        ]);
        try {
            $updated = DB::table('documentos')->where('id_documento', $request->id)->update([
                'fundo' => $request->fundo,
                'grupo' => $request->grupo,
                'num_ordem' => $request->num_ordem,
                'codigo_ttd' => $request->codigo_ttd,
                'data_producao' => $request->data_producao,
                'localizacao' => $request->localizacao,
                'emissor' => $request->emissor,
                'funcao_emissor' => $request->funcao_emissor,
                'destinatario' => $request->destinatario,
                'funcao_destinatario' => $request->funcao_destinatario,
                'formato_suporte' => $request->formato_suporte,
                'quantidade' => $request->quantidade,
                'identificacao' => $request->identificacao,
                'observacao' => $request->observacao,
                'usuario' => auth()->user() !== null ? auth()->user()->nome : null,
            ]);
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $formatedLocalizacao = "\\Localização " . str_replace('/', '.', $request->localizacao);
                $fullDir = Config::get('app.app_files_path') . $formatedLocalizacao;
                if (!Storage::disk('externo')->exists($fullDir)) {
                    $dirCreated = Storage::disk('externo')->makeDirectory($fullDir);
                    if (!$dirCreated) {
                        return redirect()->route('documentAdd', ['id' => $request->id])->with('error', 'Erro ao criar diretório para armazenar arquivos');
                    }
                }
                foreach ($files as $file) {
                    $filename = "\\" . $file->getClientOriginalName();
                    $file->storeAs($fullDir, $filename, 'externo');
                    DB::table('arquivos')->insert([
                        'path' => $formatedLocalizacao . $filename,
                        'documentId' => $request->id
                    ]);
                }
            } else if (!$updated) {
                return redirect()->route('documentAdd', ['id' => $request->id])->with('error', 'Sem alterações');
            }
            return redirect()->route('documentAdd', ['id' => $request->id])->with('success', 'Documento editado com sucesso');

        } catch (\Exception $e) {
            return redirect()->route('documentAdd', ['id' => $request->id])->with('error', $e->getMessage());
        }
    }

    public function deleteDocument(Request $request)
    {
        try {
            //Deleting files
            //Deleting arquchives
            $archives = DocumentArchive::where('documentId', $request->id)->get();
            $documentbaseFolder = null;
            for ($i = 0; $i < count($archives); $i++) {
                $archive = $archives[$i];
                if ($i == 0) {
                    $split = explode('/', $archive->path);
                    if (count($split) == 1) {
                        $split = explode('\\', $archive->path);
                    }
                    $documentbaseFolder = $split[0];
                    if ($documentbaseFolder == "") {
                        $documentbaseFolder = "\\" . $split[1];
                    }
                }
                $path = Config::get('app.app_files_path') . $archive->path;
                if (Storage::disk('externo')->exists($path)) {
                    $archiveDeletedFormDisk = Storage::disk('externo')->delete($path);
                    if (!$archiveDeletedFormDisk) {
                        return back()->with('error', 'Erro ao deletar arquivos');
                    }
                }
                $deletedOnDB = DocumentArchive::where('id', $archive->id)->delete();
                if (!$deletedOnDB) {
                    return back()->with('error', 'Erro ao deletar arquivos');
                }
            }
            if ($documentbaseFolder != null) {
                //Deleting folder
                $fullDir = Config::get('app.app_files_path') . $documentbaseFolder;
                if (Storage::disk('externo')->exists($fullDir)) {
                    $dirDeleted = Storage::disk('externo')->deleteDirectory($fullDir);
                    if (!$dirDeleted) {
                        return back()->with('error', 'Erro ao deletar diretório');
                    }
                }
            }
            //Deleting document
            $deleted = DB::table('documentos')->where('id_documento', $request->id)->delete();
            if (!$deleted) {
                return back()->with('error', 'Erro ao deletar documento');
            }
            return back()->with('success', 'Documento deletado com sucesso');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteDocumentArchive(Request $request)
    {
        try {
            $archive = DB::table('arquivos')->where('id', $request->id)->first();
            if (!$archive) {
                return redirect()->back()->with('error', 'Arquivo não encontrado');
            }
            $path = Config::get('app.app_files_path') . $archive->path;
            //remove file form disk
            if (Storage::disk('externo')->exists($path)) {
                $archiveDeletedFormDisk = Storage::disk('externo')->delete($path);
                if (!$archiveDeletedFormDisk) {
                    return redirect()->back()->with('error', 'Erro ao deletar arquivo do dísco');
                }
            }
            $deleted = DB::table('arquivos')->where('id', $request->id)->delete();
            //verify deleted
            if ($deleted) {
                return redirect()->route('documentAdd', ['id' => $request->id_documento])->with('success', 'Arquivo deletado com sucesso');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('error', 'Erro ao deletar arquivo');
    }

    public function users(Request $request)
    {
        $query = $request->query();
        if (isset($query['sort'])) {
            $users = User::orderBy($query['sort'], $query['order']);
        } else {
            $users = User::orderBy('Nome');
        }
        if (isset($query['search'])) {
            $querySearch = $query['search'];
            $users = $users->where((function ($query) use ($querySearch) {
                $query->where('Nome', 'like', '%' . $querySearch . '%')->
                orWhere('email', 'like', '%' . $querySearch . '%');
            }));
        }
        $userCount = $users->count();
        $maxPage = ceil($userCount / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $users = $users->paginate(15);
        $query = $request->query();
        $columns = [
            [
                'name' => 'Nome',
                'key' => 'Nome'
            ],
            [
                'name' => 'Status',
                'key' => 'status'
            ],
            [
                'name' => 'Email',
                'key' => 'email'
            ],
            [
                'name' => 'Dt. Cadastro',
                'key' => 'dataRegistro'
            ],
            [
                'name' => 'Último login',
                'key' => 'ultimoLogin'
            ],
            [
                'name' => '',
                'key' => 'actions'
            ]
        ];
        return view('admin.users', ['users' => $users, 'query' => $query, 'maxPage' => $maxPage, 'columns' => $columns,
            'userCount' => $userCount, 'search' => $query['search'] ?? '']);
    }

    public function toggleUserPermission(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $user = User::where('id_usuario', $id)->first();
            if ($user) {
                if ($user->cargo == 'adm') {
                    $user->cargo = 'est';
                } else {
                    $user->cargo = 'adm';
                }
                $res = $user->save();
                if ($res) {
                    return back()->with('success', 'Permissão atualizada com sucesso!');
                } else {
                    return back()->with('error', 'Erro ao atualizar permissão!');
                }
            } else {
                return back()->with('error', 'Usuário não encontrado!');
            }
        } else {
            return back()->with('error', 'Erro ao atualizar permissão!');
        }
    }

    public function toggleUserActive(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $user = User::where('id_usuario', $id)->first();
            if ($user->status == 'Aceito') {
                $user->status = 'Espera';
            } else {
                $user->status = 'Aceito';
            }
            $res = $user->save();
            if ($res) {
                return back()->with('success', 'Usuário atualizado com sucesso!');
            } else {
                return back()->with('error', 'Erro ao atualizar usuário!');
            }
        } else {
            return back()->with('error', 'Usuário não encontrado!');
        }
    }

    public function deleteUser(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $user = User::where('id_usuario', $id)->first();
            $res = $user->delete();
            if ($res) {
                return back()->with('success', 'Usuário excluído com sucesso!');
            } else {
                return back()->with('error', 'Erro ao excluir usuário!');
            }
        } else {
            return back()->with('error', 'Usuário não encontrado!');
        }
    }

    public function insertUser(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('admin.insertUser');
        }
        $registerValidated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required',
            'confirmPassword' => 'required',
            'cargo' => 'required'
        ]);
        try {
            if ($registerValidated['password'] != $registerValidated['confirmPassword']) {
                return back()->with('error', 'As senhas não coincidem!');
            }
            $user = new User();
            $user->Nome = $request->name;
            $user->email = $request->email;
            $user->senha = sha1($request->password);
            $user->cargo = $request->cargo;
            $user->status = 'Aceito';
            $res = $user->save();
            if ($res) {
                return back()->with('success', 'Usuário cadastrado com sucesso!');
            } else {
                return back()->with('error', 'Erro ao cadastrar usuário!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
