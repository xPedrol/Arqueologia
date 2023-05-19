<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Config;

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

}
