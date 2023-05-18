<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;


class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
        /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.sendmail',
            with: [
                'title' => $this->data['title'],
                'body' => $this->data['body']
            ]
        );
    }

    public function envelope()
    {
        return new Envelope(
            subject: $this->data['subject']??'Arquivo Câmara de Viçosa',
        );
    }

}
