<?php

namespace App\Mail;

use App\Domain\Entity\Email\Envelope as EmailEnvelope;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class MailEnvelope extends Mailable
{
    public function __construct(
        protected EmailEnvelope $envelope
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->envelope->header->from, $this->envelope->header->receiver),
            to: [
                new Address($this->envelope->header->to, $this->envelope->header->sender)
            ],
            subject: $this->envelope->header->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.message',
            with: [
                'header' => $this->envelope->header,
                'body' => $this->envelope->body
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
