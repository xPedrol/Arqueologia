<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Informative extends Controller
{
    public function home()
    {
        return view('informative.home');
    }
    public function add()
    {
        return view('informative.add');
    }
    public function adding(Request $request)
    {

    }
    public function edit($id)
    {
        return view('informative.edit');
    }
    public function editing(Request $request)
    {

    }
    public function delete(Request $request)
    {

    }
}
