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

    public function history()
    {
        return view('history');
    }

    public function contactUs()
    {
        return view('contactUs');
    }

    public function contactUsPost()
    {
        $validated = request()->validate([
            'email' => 'required|email',
            'assunto' => 'required',
            'nome' => 'required',
            'texto' => 'required',
        ]);
        try {
            $data = request()->only(['email', 'assunto', 'nome', 'texto']);
            if ($data['email'] != 'sample@email.tst') {
                $data['assunto'] = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $data['assunto']);
                require base_path("vendor/autoload.php");

                $subject = "Fale Conosco [Arquivo Câmara]: " . $data['assunto'];
                $body = "
            E-mail enviado pelo Fale Conosco do Arquivo da Câmara Municipal de Viçosa:<br>

            Nome: " . $data['nome'] . "<br>
            Email: " . $data['email'] . "<br>
            <br><br><br>
            Mensagem: <br>"
                    . $data['texto'] . "
        ";
                $hostEmail = Config::get('app.mail_host');

                $details = [
                    'email' => $hostEmail,
                    'subject' => $subject,
                    'body' => $body,
                    'title' => 'Fale conosco'
                ];

                dispatch(new SendEmailJob($details));
                return redirect()->route('contactUs')->with("success", 'Mensagem enviada com sucesso!');
            }
            return redirect()->route('contactUs')->with("error", 'Erro ao enviar mensagem!');
        }catch (\Exception $e) {
            return redirect()->route('contactUs')->with("error", $e->getMessage());
        }
    }

    public function useTerms()
    {
        return view('useTerms');
    }

}
