<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Highlight extends Controller
{
    //
    public function home()
    {
        return view('highlight.home');
    }
    public function add()
    {
        return view('highlight.add');
    }
    public function adding(Request $request)
    {

    }
    public function edit($id)
    {
        return view('highlight.edit');
    }
    public function editing(Request $request)
    {

    }
    public function delete(Request $request)
    {

    }
}
