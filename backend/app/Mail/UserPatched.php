<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserPatched extends Mailable
{
    use Queueable, SerializesModels;

 
    public function __construct(public $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Váš účet byl upraven',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'UserPatched',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
