<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EstateDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $data)
    {
     
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vaše nemovitost byla smazána',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'EstateDeleted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
