<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\RelatoArchive;
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
                        RelatoArchive::insert([
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
                $files = RelatoArchive::where('documentId', $id)->get();
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
            $archives = RelatoArchive::where('documentId', $request->id)->get();
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
                $deletedOnDB = RelatoArchive::where('id', $archive->id)->delete();
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
    public function toggleUserPermission(Request $request)
    {
        try {
            $id = $request->id;
            $role = $request->role;
            $roles = ['admin', 'user', 'intern'];
            if (!in_array($role, $roles)) {
                return back()->with('error', 'Permissão inválida!');
            }
            $user = User::where('id', $id)->first();
            if ($user) {
                $user->role = $role;
                $res = $user->save();
                if ($res) {
                    return back()->with('success', 'Permissão atualizada com sucesso!');
                } else {
                    return back()->with('error', 'Erro ao atualizar permissão!');
                }
            } else {
                return back()->with('error', 'Usuário não encontrado!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggleUserActive(Request $request)
    {
        try {
            $id = $request->id;
            $user = User::where('id', $id)->first();
            if ($user->status == 'active') {
                $user->status = 'disable';
            } else {
                $user->status = 'active';
            }
            $res = $user->save();
            if ($res) {
                return back()->with('success', 'Usuário atualizado com sucesso!');
            } else {
                return back()->with('error', 'Erro ao atualizar usuário!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            $id = $request->query('id');
            if ($id) {
                $user = User::where('id', $id)->first();
                $res = $user->delete();
                if ($res) {
                    return back()->with('success', 'Usuário excluído com sucesso!');
                } else {
                    return back()->with('error', 'Erro ao excluir usuário!');
                }
            } else {
                return back()->with('error', 'Usuário não encontrado!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function insertUser(Request $request)
    {
        try {
            $id = $request->query('id');
            $user = User::where('id', $id)->first();
            return view('inserirUsuario', ['user' => $user]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function insertUserPost(Request $request)
    {
        $registerValidated = $request->validate([
            'email' => 'required',
            'socialName' => 'required',
            'login' => 'required',
        ]);
        try {
            $data = $request->only(['nome', 'login', 'birthDate', 'institution', 'socialName', 'link', 'location','email','role','aboutMe']);
            $data['keepPublic'] = $request['keepPublic'] == 'on' ? true : false;
            $data['status'] = $request['status'] == 'on' ? 'active' : 'disable';
            $id = null;
            if(isset($request['id'])) {
                $id = $request['id'];
            }
            if ($id) {
                $user = User::where('id', $id)->first();
                if ($user) {
                    $data['updatedAt'] = now();
                    $res = User::where('id', $user->id)->update($data);
                } else {
                    return back()->with('error', 'Usuário não encontrado!');
                }
            } else {
                if (!isset($request['password']) || !$request['password']) {
                    return back()->with('error', 'Senha não pode ser vazia!');
                }
                $data['password'] = sha1($request['password']);
                $data['createdAt'] = now();
                $data['updatedAt'] = now();
                $res = User::create($data);
            }
            if ($res) {
                return back()->with('success', 'Usuário criado/atualizado com sucesso!');
            } else {
                return back()->with('error', 'Dados inválidos');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
