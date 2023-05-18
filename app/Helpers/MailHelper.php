<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Config;
use PHPMailer\PHPMailer\PHPMailer;

class MailHelper
{
    public function sendMail($subject, $body, $user)
    {
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        $mailHost =  Config::get('app.mail_host');
        $mailPassword =  Config::get('app.mail_password');
        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->CharSet = "UTF-8";
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = $mailHost;   //  sender username
            $mail->Password = $mailPassword;       // sender password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;                          // port - 587/465

            $mail->setFrom($mailHost, 'Arquivo Câmara de Viçosa');
            if(is_array($user)) {
                if (!array_key_exists('email', $user)) {
                    $user['email'] = $mailHost;
                }
            }else if(!$user->email){
                $user->email = $mailHost;

            }
            $mail->addAddress($user['email'], $user['Nome']);


            if (isset($_FILES['emailAttachments'])) {
                for ($i = 0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }


            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $subject;
            $mail->Body = $body;

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return [
                    'success' => false,
                    'message' => 'Sua mensagem não pode ser enviada. Por favor, tente novamente.',
                ];
            } else {
                return ['success' => true, 'message' => 'Email enviado com sucesso!'];
            }

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function instance()
    {
        return new MailHelper();
    }
}
