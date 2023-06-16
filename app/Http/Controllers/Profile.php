<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Profile extends Controller
{
    public function myAccount()
    {
        return view('myAccount');
    }

    public function savingAccountChanges(Request $request)
    {
        $registerValidated = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'socialName' => 'required',
            'login' => 'required',
            'birthDate' => 'required',
        ]);
        try {
            $data = $request->only(['nome', 'login', 'birthDate', 'institution', 'socialName', 'link', 'location']);
            $user = User::where('email', $request['email'])->where('password', sha1($request['password']))->first();
            if ($user) {
                $user::where('id', $user->id)->update($data);
                return back()->with('success', 'Dados alterados com sucesso');
            } else {
                return back()->with('error', 'Dados inválidos');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
