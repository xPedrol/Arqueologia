<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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
        $cidadesQF = DB::table('cidades')->get();
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
        $query = $request->query();
        $documento = null;
        $cidadeAtual = null;
        if ($request->query()['from'] != 'ibgeHistorico') {
            if($request->query()['from'] != 'arquivoPublico') {
                $type = 'library';
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
            if (isset($query['id'])) {
                $id = $query['id'];
                $documento = DB::table('historicoibge')->where('id', $id)->first();
                $cidadeAtual = DB::table('cidades')->where('id', $documento->cityId)->first();
            } else {
                $cidadeAtual = DB::table('cidades')->where('id', $query['cidadeId'])->first();
            }
        }
        $cidades = DB::table('cidades')->get();
        return view('inserirCidadeDoc', ['type' => $type, 'cidades' => $cidades, 'documento' => $documento, 'cidadeAtual' => $cidadeAtual]);
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
                return redirect()->route($route, ['id' => $data['cityId']])->with('success', 'Documento inserido/editado com sucesso');
            } else {
                return back()->with('error', 'Erro ao inserir/editar o documento');
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
        $userCount = $users->count();
        $maxPage = ceil($userCount / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $users = $users->paginate(100);
        $query = $request->query();
        $columns = [
            [
                'name' => 'Nome',
                'key' => 'login'
            ],
            [
                'name' => 'Apelido',
                'key' => 'niceName'
            ],
            [
                'name' => 'Email',
                'key' => 'email'
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
        return view('members', ['users' => $users, 'query' => $query, 'maxPage' => $maxPage, 'columns' => $columns,
            'userCount' => $userCount]);
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

    public function about()
    {
        return view('about');
    }
}
