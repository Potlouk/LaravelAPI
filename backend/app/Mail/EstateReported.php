<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EstateReported extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $data)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nemovitost byla nahlášena',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'EstateReported',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
