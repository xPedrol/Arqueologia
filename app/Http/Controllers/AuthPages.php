<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Jobs\SendEmailJob;
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
        if (\Illuminate\Support\Facades\Auth::attempt(['email' => $email, 'password' => $password])) {
            //update last login
            $user->lastAccess = now();
            if(!$user->role) {
                $user->role = 'user';
            }
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
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required',
            'login' => 'required',
            'bithDate' => 'required',
        ]);
        try {
            if ($request['password'] !== $request['confirmPassword']) {
                return back()->with('error', 'As senhas não conferem');
            }
            $user = new User();
            $user->role = 'user';
            $user->email = $request['email'];
            $user->password = sha1($request['password']);
            $user->login = $request['login'];
            $user->birthDate = $request['bithDate'];
            $user->location = $request['location'];
            $user->link = $request['link'];
            $user->token = sha1($request['email'] . $request['password']);
            $user->status = 'disable';
            $user->token = substr($user->token, 0, 11);
//            print_r($user);
//            return;
            $storedUser = User::where('email', $user->email)->first();
            if ($storedUser != null) {
                return back()->with('error', 'Email já cadastrado');
            }
            $res = $user->save();
            if ($res) {
                $base_url = Config::get('app.env') === 'local' ? Config::get('app.app_url') . ":" . Config::get('app.app_port') : Config::get('app.app_url');
                $encodedEmail = urlencode($user->email);
                $tokenEncoded = urlencode($user->token);
                $link = "$base_url/confirmEmail?email=$encodedEmail&token=$tokenEncoded";
                $body = "Recebemos seu cadastro. Para utilizar sua conta é precisa verificar este email. Para isso, basta clicar no botão abaixo.<br/><br/>";
                $body .= "<a href='$link' style='background-color: #212529; padding: 8px 8px; border: none; color: white; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;'>Confirmar Cadastro</a>";
                $details = [
                    'email' => $user->email,
                    'subject' => 'Confirmação de Email',
                    'title' => "Olá, " . $user->login . ".",
                    'body' => $body
                ];
                dispatch(new SendEmailJob($details));
//            MailHelper::instance()->sendMail($subject, $body, $user);
                return redirect()->route('login')->with('success', 'Usuário cadastrado com sucesso! Um link de confirmação foi enviado para seu email.');
            } else {
                return back()->with('error', 'Erro ao cadastrar');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
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
        try {
            $user = User::where('email', $request['email'])->first();
            if ($user) {
                $base_url = Config::get('app.env') == 'local' ? Config::get('app.app_url') . ":" . Config::get('app.app_port') : Config::get('app.app_url');
                $emailEncoded = urlencode($user->email);
                $tokenEncoded = urlencode($user->token);
                $link = "$base_url/nova-senha?email=$emailEncoded&token=$tokenEncoded";
                $body = "Foi solicitada uma atualização de senha. Para realizar esta operação, clique no botão abaixo.<br/><br/>";
                $body .= "<a href='$link' style='background-color: #005b5a; padding: 8px 8px; border: none; color: white; text-align: center; text-decoration: none; display: inline-block; font-size: 16px;'>Alterar Senha</a>";
                $details = [
                    'email' => $user->email,
                    'subject' => 'Alterar Senha',
                    'title' => "Olá, " . $user->socialName . ".",
                    'body' => $body
                ];
                dispatch(new SendEmailJob($details));
                return back()->with('success', 'Um email com alteração de senha foi enviado para você!');

            }
            return redirect('forgotPassword')->with("error", 'Email não encontrado');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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
            'newPassword' => 'required',
        ]);
        try {
            $user = User::where('email', $request['email'])->first();
            if ($user) {
                if ($user['token'] == $request['token']) {
                    $user['password'] = sha1($request['newPassword']);
                    $res = $user->save();
                    if ($res) {
                        return redirect()->route('login')->with("success", 'Senha atualizada com sucesso!');
                    }
                }
            }
            $emailEncoded = urlencode($request['email']);
            $tokenEncoded = urlencode($request['token']);
            return redirect()->route('newPassword', ['email' => $emailEncoded, 'token' => $tokenEncoded])->with("error", 'Erro ao atualizar senha');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirmEmail(Request $request)
    {
        $email = $request->get('email') ?? null;
        $token = $request->get('token') ?? null;
        $user = User::where('email', $email)->first();
        echo $email;
        echo(!!$user);
        if ($user) {
            if ($user['token'] == $token) {
                $user->status = 'active';
                $res = $user->save();
                if ($res) {
                    return redirect()->route('login')->with("success", 'Email confirmado com sucesso!');
                }
            }
        }
        return redirect()->route('login')->with("error", 'Erro ao confirmar email');
    }
}
