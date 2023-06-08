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

    public function fontes()
    {
        $cidadesQF = DB::table('cidades')->get();
        return view('fontes', ['cidadesQF' => $cidadesQF]);
    }

    public function ibgeHistorico(Request $request)
    {
        //get route name
        $name = $request->route()->getName();
        $isIbgeHistorico = $name == 'ibgeHistorico';
        $id = $request->query('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $biblioteca = DB::table('historicoibge')->where('cityId', $id)->first();
        return view('tabela', ['cidade' => $cidade, 'biblioteca' => $biblioteca, 'isIbgeHistorico' => $isIbgeHistorico]);
    }

    public function arquivoPublico(Request $request)
    {
        $name = $request->route()->getName();
        $isArquivoPublico = $name == 'arquivoPublico';
        $id = $request->query('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $biblioteca = DB::table('dadoscidades')->where('cityId', $id)->where('type','archive')->first();
        return view('tabela', ['cidade' => $cidade, 'biblioteca' => $biblioteca,'isArquivoPublico' => $isArquivoPublico]);
    }
    public function bibliotecaNacional(Request $request)
    {
        $name = $request->route()->getName();
        $isBibliotecaNacional = $name == 'bibliotecaNacional';
        $id = $request->query('id');
        $cidade = DB::table('cidades')->where('id', $id)->first();
        $biblioteca = DB::table('dadoscidades')->where('cityId', $id)->where('type','library')->first();
        return view('tabela', ['cidade' => $cidade, 'biblioteca' => $biblioteca,'isBibliotecaNacional' => $isBibliotecaNacional]);
    }

    public function tabela()
    {
        return view('tabela');
    }

    public function members(Request $request){
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


    public function contact(){
        return view('contact');
    }

    public function about(){
        return view('about');
    }
}
