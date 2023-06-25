<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Jobs\SendEmailJob;
use App\Models\Bibliografia;
use App\Models\BibliografiaArchive;
use App\Models\DocumentArchive;
use App\Models\RelatoArchive;
use App\Models\RelatoQuadrilatero;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Home extends Controller
{
    public function home()
    {
        return view('home');
    }

    function getFontesPagination(Request $request, $sql, $table)
    {
        $count = $sql->count();
        $maxPage = ceil($count / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $query = $request->query();
        if ($table != 'historicoibge') {
            if (isset($query['sort'])) {
                $sql = $sql->orderBy($query['sort'], $query['order']);
            } else {
                $sql = $sql->orderBy('title');
            }
        }
        $sql = $sql->paginate(15);
        $columns = [
            [
                'name' => 'Material',
                'key' => 'material'
            ],
            [
                'name' => 'Título',
                'key' => 'title'
            ],
            [
                'name' => 'Ano',
                'key' => 'year'
            ],
            [
                'name' => 'Assunto',
                'key' => 'subject'
            ],
            [
                'name' => 'Observações',
                'key' => 'comments'
            ],
            [
                'name' => 'Link',
                'key' => 'link'
            ],
            [
                'name' => '',
                'key' => 'actions'
            ]
        ];
        return [
            'sql' => $sql,
            'columns' => $columns,
            'query' => $query,
            'maxPage' => $maxPage,
            'count' => $count
        ];
    }

    public function fontes()
    {
        $cidadesQF = DB::table('cidades')->orderBy('name')->get();
        return view('fontes', ['cidadesQF' => $cidadesQF]);
    }

    public function ibgeHistorico(Request $request)
    {
        //get route name
        $title = 'IBGE Histórico';
        $id = $request->route('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $array = DB::table('historicoibge')->where('cityId', $id);
        $data = $this->getFontesPagination($request, $array, 'historicoibge');
        $array = $data['sql'];
        $columns = $data['columns'];
        $query = $data['query'];
        $maxPage = $data['maxPage'];
        $count = $data['count'];
        $route = 'ibgeHistorico';
        foreach ($array as $item) {
            //split string by -
            $item->url = explode(' - ', $item->url);
            //remove indexs with white space
            $item->url = array_filter($item->url, function ($value) {
                return $value != ' ';
            });
        }
        return view('detalhesDoc', ['cidade' => $cidade, 'array' => $array,
            'isIbgeHistorico' => true, 'title' => $title, 'columns' => $columns,
            'query' => $query, 'maxPage' => $maxPage, 'count' => $count, 'route' => $route]);
    }

    public function arquivoPublico(Request $request)
    {
        $title = 'Arquivo Público';
        $id = $request->route('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $array = DB::table('dadoscidades')->where('cityId', $id)->where('type', 'archive');
        $data = $this->getFontesPagination($request, $array, 'dadoscidades');
        $array = $data['sql'];
        $columns = $data['columns'];
        $query = $data['query'];
        $maxPage = $data['maxPage'];
        $count = $data['count'];
        $route = 'arquivoPublico';
        return view('detalhesDoc', ['cidade' => $cidade, 'array' => $array,
            'isArquivoPublico' => true, 'title' => $title, 'columns' => $columns,
            'query' => $query, 'maxPage' => $maxPage, 'count' => $count, 'route' => $route]);
    }

    public function bibliotecaNacional(Request $request)
    {
        $title = 'Biblioteca Nacional';
        $id = $request->route('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $array = DB::table('dadoscidades')->where('cityId', $id)->where('type', 'library');
        $data = $this->getFontesPagination($request, $array, 'dadoscidades');
        $array = $data['sql'];
        $columns = $data['columns'];
        $query = $data['query'];
        $maxPage = $data['maxPage'];
        $count = $data['count'];
        $route = 'bibliotecaNacional';
        return view('detalhesDoc', ['cidade' => $cidade, 'array' => $array,
            'isBibliotecaNacional' => true, 'title' => $title, 'columns' => $columns,
            'query' => $query, 'maxPage' => $maxPage, 'count' => $count, 'route' => $route]);
    }

    public function inserirCidadeDocumento(Request $request)
    {
        $type = 'archive';
        $previousRoute = 'arquivoPublico';
        $query = $request->query();
        $documento = null;
        $cidadeAtual = null;
        if ($request->query()['from'] != 'ibgeHistorico') {
            if ($request->query()['from'] != 'arquivoPublico') {
                $type = 'library';
                $previousRoute = 'bibliotecaNacional';
            }
            if (isset($query['id'])) {
                $id = $query['id'];
                $documento = DB::table('dadoscidades')->where('id', $id)->first();
                $cidadeAtual = DB::table('cidades')->where('id', $documento->cityId)->first();
            } else {
                $cidadeAtual = DB::table('cidades')->where('id', $query['cidadeId'])->first();
            }
        }
        if ($request->query()['from'] == 'ibgeHistorico') {
            $type = 'historico';
            $previousRoute = 'ibgeHistorico';
            if (isset($query['id'])) {
                $id = $query['id'];
                $documento = DB::table('historicoibge')->where('id', $id)->first();
                $cidadeAtual = DB::table('cidades')->where('id', $documento->cityId)->first();
            } else {
                $cidadeAtual = DB::table('cidades')->where('id', $query['cidadeId'])->first();
            }
        }
        $cidades = DB::table('cidades')->get();
        return view('inserirCidadeDoc', ['type' => $type, 'cidades' => $cidades, 'documento' => $documento, 'cidadeAtual' => $cidadeAtual, 'previousRoute' => $previousRoute]);
    }

    public function deletarCidadeDocumento(Request $request)
    {
        try {
            $id = $request['id'];
            if ($request['from'] != 'ibgeHistorico') {
                $res = DB::table('dadoscidades')->where('id', $id)->delete();
            } else {
                $res = DB::table('historicoibge')->where('id', $id)->delete();
            }
            if ($res) {
                return redirect()->back()->with('success', 'Documento deletado com sucesso!');
            } else {
                return redirect()->back()->withErrors(['msg' => 'Erro ao deletar documento!']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
    }

    public function inserirCidadeDocumentoPost(Request $request)
    {
        $type = $request['type'];
        if ($type == 'historico') {
            request()->validate([
                'cityId' => 'required',
                'description' => 'required',
                'type' => 'required',
            ]);
            try {
                $data = $request->all();
                if (!isset($data['id'])) {
                    $res = DB::table('historicoibge')->insert([
                        'cityId' => $data['cityId'],
                        'description' => $data['description'],
                        'url' => $data['url'],
                        'legend' => $data['legend'],
                    ]);
                } else {
                    $res = DB::table('historicoibge')->where('id', $data['id'])->update([
                        'cityId' => $data['cityId'],
                        'description' => $data['description'],
                        'url' => $data['url'],
                        'legend' => $data['legend'],
                    ]);
                }
                if ($res) {
                    return redirect()->route('ibgeHistorico', ['id' => $data['cityId']])->with('success', 'Histórico inserido/editado com sucesso');
                } else {
                    return back()->with('error', 'Erro ao inserir/editar o histórico');
                }
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }

        } else {
            request()->validate([
                'title' => 'required',
                'subject' => 'required',
                'comments' => 'required',
                'type' => 'required',
                'cityId' => 'required',
            ]);
            $data = $request->all();
            if (!isset($data['id'])) {
                $res = DB::table('dadoscidades')->insert([
                    'title' => $data['title'],
                    'subject' => $data['subject'],
                    'author' => $data['author'],
                    'legend' => $data['legend'],
                    'type' => $data['type'],
                    'cityId' => $data['cityId'],
                    'year' => $data['year'],
                    'link' => $data['link'],
                    'comments' => $data['comments'],
                    'material' => 'Manunscrito'
                ]);
            } else {
//                print_r($data['id']);
//                return;
                $res = DB::table('dadoscidades')->where('id', $data['id'])->update([
                    'title' => $data['title'],
                    'subject' => $data['subject'],
                    'author' => $data['author'],
                    'legend' => $data['legend'],
                    'type' => $data['type'],
                    'cityId' => $data['cityId'],
                    'year' => $data['year'],
                    'link' => $data['link'],
                    'comments' => $data['comments'],
                ]);
            }
            if ($res) {
                $route = $data['type'] == 'archive' ? 'arquivoPublico' : 'bibliotecaNacional';
                if (isset($data['id'])) {
                    return back()->with('success', 'Documento atualizado com sucesso');
                }
                return redirect()->route($route, ['id' => $data['cityId']])->with('success', 'Documento inserido com sucesso');
            } else {
                if (isset($data['id'])) {
                    return back()->with('error', 'Erro ao atualizar o documento');
                }
                return back()->with('error', 'Erro ao inserir o documento');
            }
        }
    }

    public function members(Request $request)
    {
        $query = $request->query();
        if (isset($query['sort'])) {
            $users = User::orderBy($query['sort'], $query['order']);
        } else {
            $users = User::orderBy('login');
        }
        $users = $users->where('role', '=', 'user')->where('keepPublic', '=', '1');
        $userCount = $users->count();
        $maxPage = ceil($userCount / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $users = $users->paginate(100);
        $query = $request->query();
        $columns = [
            [
                'name' => 'Nome',
                'key' => 'socialName'
            ],
            [
                'name' => 'Email',
                'key' => 'email'
            ],
            [
                'name' => 'Instituição',
                'key' => 'institution'
            ],
            [
                'name' => 'Sobre',
                'key' => 'aboutMe'
            ],
            [
                'name' => 'Link',
                'key' => 'url'
            ],
            [
                'name' => '',
                'key' => 'actions',
            ]
        ];
        return view('members', ['users' => $users, 'query' => $query, 'maxPage' => $maxPage, 'columns' => $columns,
            'userCount' => $userCount, 'count' => $userCount]);
    }

    public function users(Request $request)
    {
        $query = $request->query();
        if (isset($query['sort'])) {
            $users = User::orderBy($query['sort'], $query['order']);
        } else {
            $users = User::orderBy('login');
        }
        $search = null;
        if (isset($query['search'])) {
            $users = $users->where('login', 'like', '%' . $query['search'] . '%')
                ->orWhere('socialName', 'like', '%' . $query['search'] . '%')
                ->orWhere('email', 'like', '%' . $query['search'] . '%')
                ->orWhere('institution', 'like', '%' . $query['search'] . '%')
                ->orWhere('url', 'like', '%' . $query['search'] . '%')
                ->orWhere('role', 'like', '%' . $query['search'] . '%')
                ->orWhere('status', 'like', '%' . $query['search'] . '%');
            $search = $query['search'];
        }
        $userCount = $users->count();
        $maxPage = ceil($userCount / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $users = $users->paginate(100);
        $query = $request->query();
        $columns = [
            [
                'name' => 'Login',
                'key' => 'login'
            ],
            [
                'name' => 'Nome',
                'key' => 'socialName'
            ],
            [
                'name' => 'Email',
                'key' => 'email'
            ],
            [
                'name' => 'Ultimo acesso',
                'key' => 'lastAccess'
            ],
            [
                'name' => 'Dt. Cadastro',
                'key' => 'createdAt'
            ],
            [
                'name' => 'Status',
                'key' => 'status',
                'show' => Auth::check() && Auth::user()->isAdmin()
            ],
            [
                'name' => 'Permissão',
                'key' => 'role',
                'show' => Auth::check() && Auth::user()->isAdmin()
            ],
            [
                'name' => '',
                'key' => 'actions',
                'show' => Auth::check() && Auth::user()->isAdmin()
            ]
        ];
        return view('users', ['users' => $users, 'query' => $query, 'maxPage' => $maxPage, 'columns' => $columns,
            'count' => $userCount, 'search' => $search]);
    }


    public function contact()
    {
        return view('contact');
    }

    public function contactUsPost()
    {
        request()->validate([
            'email' => 'required|email',
            'assunto' => 'required',
            'nome' => 'required',
            'texto' => 'required',
        ]);
        $data = request()->only(['email', 'assunto', 'nome', 'texto']);
        if ($data['email'] != 'sample@email.tst') {
            $data['assunto'] = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $data['assunto']);
            require base_path("vendor/autoload.php");

            $subject = "Fale Conosco [LAMPEH]: " . $data['assunto'];
            $body = "
            <h4>E-mail enviado pelo Fale Conosco do Patrimônio Arqueológico.</h4>

            Nome: " . $data['nome'] . "<br>
            Email: " . $data['email'] . "<br>
            <br>
            Mensagem: <br>"
                . $data['texto'] . "
        ";
            $hostEmail = Config::get('app.mail_host');
            if ($hostEmail) {
                $details = [
                    'email' => $hostEmail,
                    'subject' => $subject,
                    'body' => $body,
                    'title' => ''
                ];
                dispatch(new SendEmailJob($details));
            }
            return back()->with("success", 'Mensagem enviada com sucesso!');
        }
        return back()->with("error", 'Erro ao enviar mensagem!');
    }

    public function inserirCidadePost(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $data = $request->all();
            $res = DB::table('cidades')->insert([
                'name' => $data['name'],
            ]);
            if ($res) {
                return redirect()->route('fontes')->with('success', 'Cidade inserida com sucesso');
            } else {
                return back()->with('error', 'Erro ao inserir a cidade');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function relatosQuadrilatero(Request $request)
    {
        $query = $request->query();
        $relatos = RelatoQuadrilatero::query();
        $search = '';
        if (isset($query['search'])) {
            $search = $query['search'];
            $relatos = $relatos->where('title', 'like', '%' . $query['search'] . '%')
                ->orWhere('author', 'like', '%' . $query['search'] . '%')
                ->orWhere('registration', 'like', '%' . $query['search'] . '%')
                ->orWhere('createdAt', 'like', '%' . $query['search'] . '%')
                ->orWhere('updatedAt', 'like', '%' . $query['search'] . '%');
        }
        if (isset($query['sort'])) {
            $relatos = $relatos->orderBy($query['sort'], $query['order']);
        } else {
            $relatos = $relatos->orderBy('author');
        }
        $count = $relatos->count();
        $maxPage = ceil($count / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $relatos = $relatos->paginate(15);
        $query = $request->query();
        $columns = [
            [
                'name' => 'Título',
                'key' => 'title'
            ],
            [
                'name' => 'Autor',
                'key' => 'author'
            ],
            [
                'name' => 'Fichamento',
                'key' => 'registration'
            ],
            [
                'name' => 'Dt. Cadastro',
                'key' => 'createdAt'
            ],
            [
                'name' => '',
                'key' => 'actions'
            ]
        ];
        return view('relatosQuadrilatero', ['relatos' => $relatos, 'query' => $query, 'maxPage' => $maxPage, 'columns' => $columns,
            'count' => $count, 'search' => $search]);
    }

    public function inserirRelatoQuadrilatero(Request $request)
    {
        $relato = null;
        $files = null;
        $query = $request->query();
        if (isset($query['id'])) {
            $id = $query['id'];
            $relato = DB::table('relatosquadrilatero')->where('id', $id)->first();
            $files = RelatoArchive::where('relatosQId', $id)->get();
        }
        return view('inserirRelatoQuadrilatero', ['relato' => $relato, 'files' => $files]);
    }

    public function inserirRelatoQuadrilateroPost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'registration' => 'required',
        ]);
        try {
            if (!is_dir(Config::get('app.app_files_path'))) {
                mkdir(Config::get('app.app_files_path'), 0777, true);
            }
            $data = $request->all();
            if (!isset($data['id'])) {
                $res = DB::table('relatosquadrilatero')->insert([
                    'author' => $data['author'],
                    'registration' => $data['registration'],
                    'title' => $data['title'],
                    'legend' => $data['legend'],
                ]);
            } else {
                //verify if changed
                $relato = DB::table('relatosquadrilatero')->where('id', $data['id'])->first();
                if ($relato->author == $data['author'] && $relato->registration == $data['registration'] && $relato->title == $data['title'] && $relato->legend == $data['legend']) {
                    $res = true;
                } else {
                    $res = DB::table('relatosquadrilatero')->where('id', $data['id'])->update([
                        'author' => $data['author'],
                        'registration' => $data['registration'],
                        'title' => $data['title'],
                        'legend' => $data['legend'],
                    ]);
                }
            }
            if ($res) {
                if (isset($data['id'])) {
                    $newId = $data['id'];
                } else {
                    $newId = DB::getPdo()->lastInsertId();
                }
                $fullDir = Config::get('app.app_files_path');
                if ($request->hasFile('sheets')) {
                    $files = $request->file('sheets');
                    foreach ($files as $file) {
                        $filename = "\\" . Config::get('app.relatosdocs_sheet') . "." . $newId . "." . $file->getClientOriginalName();
                        $file->storeAs($fullDir, $filename, 'externo');
                        DB::table('relatosdocs')->insert([
                            'path' => $filename,
                            'relatosQId' => $newId,
                            'type' => 'sheet'
                        ]);
                    }
                }
                if ($request->hasFile('book')) {
                    $file = $request->file('book');
                    $filename = "\\" . Config::get('app.relatosdocs_book') . "." . $newId . "." . $file->getClientOriginalName();
                    $file->storeAs($fullDir, $filename, 'externo');
                    DB::table('relatosdocs')->insert([
                        'path' => $filename,
                        'relatosQId' => $newId,
                        'type' => 'book'
                    ]);
                }
                if (isset($data['id'])) {
                    return back()->with('success', 'Relato atualizado com sucesso');
                }
                return redirect()->route('relatosQuadrilatero')->with('success', 'Relato inserido com sucesso');
            } else {
                if (isset($data['id'])) {
                    return back()->with('error', 'Erro ao atualizar o relato');
                }
                return back()->with('error', 'Erro ao inserir o relato');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function detalhesRelatosQuadrilatero(Request $request)
    {
        $id = $request['id'];
        $relato = DB::table('relatosquadrilatero')->where('id', $id)->first();
        $files = RelatoArchive::where('relatosQId', $id)->get();
        return view('detalhesRelatoQuadrilatero', ['relato' => $relato, 'files' => $files]);
    }

    public function deletarRelatoQuadrilateroPost(Request $request)
    {
        try {
            $archive = DB::table('relatosdocs')->where('id', $request->id)->first();
            if (!$archive) {
                return redirect()->back()->with('error', 'Arquivo não encontrado');
            }
            $relatoId = $archive->relatosQId;
            $path = Config::get('app.app_files_path') . $archive->path;
            //remove file form disk
            if (Storage::disk('externo')->exists($path)) {
                $archiveDeletedFormDisk = Storage::disk('externo')->delete($path);
                if (!$archiveDeletedFormDisk) {
                    return redirect()->back()->with('error', 'Erro ao deletar arquivo do dísco');
                }
            }
            $deleted = DB::table('relatosdocs')->where('id', $request->id)->delete();
            //verify deleted
            if ($deleted) {
                return redirect()->route('inserirRelatoQuadrilatero', ['id' => $relatoId])->with('success', 'Arquivo deletado com sucesso');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('error', 'Erro ao deletar arquivo');
    }

    public function viewRelatoDoc(Request $request)
    {
        try {
            $id = $request->route('id');
            $documento = RelatoArchive::find($id);
            $path = $documento->path;
            $fullPath = Storage::disk('externo')->path(Config::get('app.app_files_path') . $path);
            // Header content type
            header('Content-type: application/pdf');

            header('Content-Disposition: inline; filename="' . $fullPath . '"');

            header('Content-Transfer-Encoding: binary');

            header('Accept-Ranges: bytes');
            ini_set('memory_limit', '-1');
            // Read the file
            @readfile($fullPath);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Arquivo não encontrado');
        }
    }

    public function viewRelatoBibliografiaDoc(Request $request)
    {
        try {
            $id = $request->route('id');
            $documento = BibliografiaArchive::find($id);
            $path = $documento->path;
            $fullPath = Storage::disk('externo')->path(Config::get('app.app_files_path') . $path);
            // Header content type
            header('Content-type: application/pdf');

            header('Content-Disposition: inline; filename="' . $fullPath . '"');

            header('Content-Transfer-Encoding: binary');

            header('Accept-Ranges: bytes');
            ini_set('memory_limit', '-1');
            // Read the file
            @readfile($fullPath);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Arquivo não encontrado');
        }
    }


    public function about()
    {
        return view('about');
    }

    public function bibliografias(Request $request)
    {
        $query = $request->query();
        $type = $request->query('type');
        $bibliografia = Bibliografia::select('bibliografia.*', DB::raw('COUNT(bibliografiadocs.id) AS docs'))
            ->leftJoin('bibliografiadocs', 'bibliografia.id', '=', 'bibliografiadocs.bibliografiaId')
            ->groupBy('bibliografia.id', 'bibliografia.author', 'bibliografia.summary',
                'bibliografia.theme', 'bibliografia.type', 'bibliografia.createdAt', 'bibliografia.updatedAt', 'bibliografia.legend');

        if (isset($type) && $type) {
            $bibliografia = $bibliografia->where('bibliografia.type', $type);
        }
        if (isset($query['sort'])) {
            $bibliografia = $bibliografia->orderBy('bibliografia.' . $query['sort'], $query['order']);
        } else {
            $bibliografia = $bibliografia->orderBy('bibliografia.author');
        }
        $count = DB::table('bibliografia')->count();
        $maxPage = ceil($count / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $bibliografia = $bibliografia->paginate(100);
        $query = $request->query();
        $columns = [
            [
                'name' => 'Autor',
                'key' => 'author'
            ],
            [
                'name' => 'Tema',
                'key' => 'theme'
            ],
            [
                'name' => 'Tipo',
                'key' => 'type'
            ],
            [
                'name' => 'Sumário',
                'key' => 'summary'
            ],
            [
                'name' => 'PDF',
                'key' => 'filePath'
            ],
            [
                'name' => 'Dt. Cadastro',
                'key' => 'createdAt'
            ],
            [
                'name' => '',
                'key' => 'actions'
            ]
        ];

        return view('bibliografias', ['bibliografias' => $bibliografia, 'query' => $query, 'maxPage' => $maxPage, 'columns' => $columns,
            'count' => $count, 'type' => $type]);
    }

    public function detalhesBibliografia(Request $request)
    {
        $id = $request['id'];
        $bibliografia = Bibliografia::where('id', $id)->first();
        $files = BibliografiaArchive::where('bibliografiaId', $id)->get();
        return view('detalhesBibliografia', ['bibliografia' => $bibliografia, 'files' => $files]);
    }

    public function inserirBibliografia(Request $request)
    {

        $bibliografia = null;
        $files = null;
        $query = $request->query();
        if (isset($query['id'])) {
            $id = $query['id'];
            $bibliografia = DB::table('bibliografia')->where('id', $id)->first();
            $files = BibliografiaArchive::where('bibliografiaId', $id)->get();
        }
        return view('inserirBibliografia', ['bibliografia' => $bibliografia, 'files' => $files]);
    }

    public function inserirBibliografiaPost(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'summary' => 'required',
            'theme' => 'required',
            'type' => 'required',
        ]);
        try {
            if (!is_dir(Config::get('app.app_files_path'))) {
                mkdir(Config::get('app.app_files_path'), 0777, true);
            }
            $data = $request->all();
            if (!isset($data['id'])) {
                $res = DB::table('bibliografia')->insert([
                    'author' => $data['author'],
                    'summary' => $data['summary'],
                    'theme' => $data['theme'],
                    'type' => $data['type'],
                    'legend' => $data['legend'],
                    'createdAt' => now(),
                    'updatedAt' => now()
                ]);
            } else {
                $res = DB::table('bibliografia')->where('id', $data['id'])->update([
                    'author' => $data['author'],
                    'summary' => $data['summary'],
                    'theme' => $data['theme'],
                    'type' => $data['type'],
                    'legend' => $data['legend'],
                    'updatedAt' => now()
                ]);
            }
            if ($res) {
                if (isset($data['id'])) {
                    $newId = $data['id'];
                } else {
                    $newId = DB::getPdo()->lastInsertId();
                }
                if ($request->hasFile('files')) {
                    $files = $request->file('files');
                    $fullDir = Config::get('app.app_files_path');
                    foreach ($files as $file) {
                        $filename = "\\" . Config::get('app.bibliografiadocs_file') . "." . $newId . "." . $file->getClientOriginalName();
                        $file->storeAs($fullDir, $filename, 'externo');
                        DB::table('bibliografiadocs')->insert([
                            'path' => $filename,
                            'bibliografiaId' => $newId
                        ]);
                    }
                }
                if (isset($data['id'])) {
                    return back()->with('success', 'Bibliografia atualizada com sucesso');
                }
                return redirect()->route('bibliografias')->with('success', 'Bibliografia inserida com sucesso');
            } else {
                if (isset($data['id'])) {
                    return back()->with('error', 'Erro ao atualizar a bibliografia');
                }
                return back()->with('error', 'Erro ao inserir a bibliografia');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deletarBibliografia(Request $request)
    {
        try {
            $id = $request['id'];
            $deleted = DB::table('bibliografia')->where('id', $id)->delete();
            if ($deleted) {
                return redirect()->route('bibliografia')->with('success', 'Bibliografia deletada com sucesso');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('error', 'Erro ao deletar bibliografia');
    }
}
