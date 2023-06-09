<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Home extends Controller
{
    public function home()
    {
        return view('home');
    }

    function getFontesPagination(Request $request, $sql,$table)
    {
        $count = $sql->count();
        $maxPage = ceil($count / 15);
        PaginationHelper::instance()->handlePagination($request, $maxPage);
        $query = $request->query();
        if($table != 'historicoibge') {
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
                'name' =>'Assunto',
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
        $data = $this->getFontesPagination($request, $array,'historicoibge');
        $array = $data['sql'];
        $columns = $data['columns'];
        $query = $data['query'];
        $maxPage = $data['maxPage'];
        $count = $data['count'];
        $route = 'ibgeHistorico';
        foreach ($array as $item) {
            //split string by -
            $item->url= explode(' - ', $item->url);
            //remove indexs with white space
            $item->url = array_filter($item->url, function ($value) {
                return $value != ' ';
            });
        }
        return view('tabela', ['cidade' => $cidade, 'array' => $array,
            'isIbgeHistorico' => true, 'title' => $title, 'columns' => $columns,
            'query' => $query, 'maxPage' => $maxPage, 'count' => $count, 'route' => $route]);
    }

    public function arquivoPublico(Request $request)
    {
        $title = 'Arquivo Público';
        $id = $request->route('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $array = DB::table('dadoscidades')->where('cityId', $id)->where('type', 'archive');
        $data = $this->getFontesPagination($request, $array,'dadoscidades');
        $array = $data['sql'];
        $columns = $data['columns'];
        $query = $data['query'];
        $maxPage = $data['maxPage'];
        $count = $data['count'];
        $route = 'arquivoPublico';
        return view('tabela', ['cidade' => $cidade, 'array' => $array,
            'isArquivoPublico' => true, 'title' => $title, 'columns' => $columns,
            'query' => $query, 'maxPage' => $maxPage, 'count' => $count, 'route' => $route]);
    }

    public function bibliotecaNacional(Request $request)
    {
        $title = 'Biblioteca Nacional';
        $id = $request->route('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $array = DB::table('dadoscidades')->where('cityId', $id)->where('type', 'library');
        $data = $this->getFontesPagination($request, $array,'dadoscidades');
        $array = $data['sql'];
        $columns = $data['columns'];
        $query = $data['query'];
        $maxPage = $data['maxPage'];
        $count = $data['count'];
        $route = 'bibliotecaNacional';
        return view('tabela', ['cidade' => $cidade, 'array' => $array,
            'isBibliotecaNacional' => true, 'title' => $title, 'columns' => $columns,
            'query' => $query, 'maxPage' => $maxPage, 'count' => $count, 'route' => $route]);
    }

    public function tabela()
    {
        return view('tabela');
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

    public function about()
    {
        return view('about');
    }
}
