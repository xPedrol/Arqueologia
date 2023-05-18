<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthPages extends Controller
{
    public function login()
    {
        return view('auth.login');

    }

    public function logging(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $email = $request['email'];
        $password = $request['password'];
        $user = User::where('email', $email)->first();
        if ($user && $user["status"] !== 'Aceito') {
            return redirect()->route('login')->with('error', 'Email não confirmado');
        }
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $password])) {
            //update last login
            $user->ultimoLogin = now();
            $user->save();
            return redirect()->route('home');
        }
        return redirect()->route('login')->with('error', 'Email ou senha incorretos');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registering(Request $request)
    {
        $registerValidated = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required',
            'name' => 'required',


        ]);
        if ($request['useTerms'] != 'on') {
            return back()->with('error', 'Você precisa aceitar os termos de uso');
        }
        if ($request['password'] !== $request['confirmPassword']) {
            return back()->with('error', 'As senhas não conferem');
        }
        $user = new User();
        $user->cargo = 'dft';
        $user->status = 'Aceito';
        $user->email = $request['email'];
        $user->senha = sha1($request['password']);
        $user->nome = $request['name'];
        $user->dataRegistro = date('Y-m-d');
        $storedUser = User::where('email', $user->email)->first();
        if ($storedUser != null) {
            return back()->with('error', 'Email já cadastrado');
        }
        $res = $user->save();
        if ($res) {
            $base_url = Config::get('app.env') === 'local' ? Config::get('app.app_url') . ":" . Config::get('app.app_port') : Config::get('app.app_url');

            $subject = "Por favor, verifique seu email";
            $body = "
              <h1>Olá $user->nome.</h1> <br>
              Recebemos seu cadastro. Para utilizar sua conta basta logar em nosssa plataforma.<br><br>

                <a href='$base_url/admin/login'>  Clique aqui para logar</a>
            ";
            $user = [
                'Nome' => $user->nome,
                'email' => $user->email,
            ];
            MailHelper::instance()->sendMail($subject, $body, $user);
            return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso!');
        } else {
            return back()->with('error', 'Erro ao cadastrar');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        return view('auth.forgotPassword');
    }

    public function forgotPasswordPost(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
        ]);
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            $subject = "Recuperação de senha";
            $base_url = Config::get('app.env') === 'local' ? Config::get('app.app_url') . ":" . Config::get('app.app_port') : Config::get('app.app_url');
            $link = "<a href='" . $base_url . "/newPassword?email=" . $request['email'] . "&token=" . $user['token'] . "'> Clique aqui!</a>";
            $body = "
              <h1>Olá " . $user->Nome . ",</h1> <br>
              Você solicitou uma atualização na sua senha. Para realizar esta operação, você precisa entrar no link abaixo:<br><br>
                $link
            ";
            $res = MailHelper::instance()->sendMail($subject, $body, $user);
            if ($res['success']) {
                return back()->with('success', 'Um email com alteração de senha foi enviado para você!');
//                return redirect('newPassword?email=' . $request['email'] . '&token=' . $user['token'])->with("success", $res['message']);
            }
        }
        return redirect('forgotPassword')->with("error", 'Email não encontrado');
    }

    public function newPassword(Request $request)
    {
        $email = $request->get('email') ?? null;
        $token = $request->get('token') ?? null;
        return view('auth.newPassword', ['email' => $email, 'token' => $token]);
    }

    public function newPasswordPost(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'newPassword' => 'required',
        ]);
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            if ($user['token'] == $request['token'] && $user['password'] == sha1($request['password'])) {
                $user->senha = sha1($request['newPassword']);
                $user->token = null;
                $res = $user->save();
                if ($res) {
                    return redirect('login')->with("success", 'Senha atualizada com sucesso!');
                }
            }
        }
//        return redirect('newPassword?email=' . $request['email'] . '&token=' . $request['token'])->with("error", 'Erro ao atualizar senha');
    }

    public function confirmEmail(Request $request)
    {
        $email = $request->get('email') ?? null;
        $token = $request->get('token') ?? null;
        $user = User::where('email', $email)->first();
        if ($user) {
            if ($user['token'] == $token) {
                $user->Emailconfirmado = 1;
                $res = $user->save();
                if ($res) {
                    return redirect('login')->with("success", 'Email confirmado com sucesso!');
                }
            }
        }
        return redirect('login')->with("error", 'Erro ao confirmar email');
    }
}
