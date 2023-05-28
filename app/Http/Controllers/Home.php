<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Models\User;
use Illuminate\Http\Request;

class Home extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function fontes()
    {
        return view('fontes');
    }

    public function tabela(){
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
