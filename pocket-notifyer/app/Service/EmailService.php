<?php

namespace App\Service;

use App\Domain\Entity\Email\Body;
use App\Domain\Entity\Email\Envelope;
use App\Domain\Entity\Email\Header;
use App\Infrastructure\Http\Entity\EmailRequest;
use App\Jobs\SendEmail;

class EmailService
{
    public function send(EmailRequest $emailRequest)
    {
        SendEmail::dispatch($this->getEnvelope($emailRequest));
    }

    private function getEnvelope(EmailRequest $emailRequest): Envelope
    {
        return new Envelope(
            $this->getHeader($emailRequest),
            $this->getBody($emailRequest)
        );
    }

    private function getHeader(EmailRequest $emailRequest): Header
    {
        return new Header(
            subject: $emailRequest->json('headers.subject'),
            from: $emailRequest->json('headers.from'),
            sender: $emailRequest->json('headers.sender'),
            to: $emailRequest->json('headers.to'),
            receiver: $emailRequest->json('headers.receiver'),
            money: $emailRequest->json('headers.money'),
            replyTo: $emailRequest->json('headers.reply_to'),
            date: $emailRequest->json('headers.date'),
        );
    }

    private function getBody(EmailRequest $emailRequest): Body
    {
        return new Body(
            body: $emailRequest->json('body.message'),
            contentType: $emailRequest->json('body.content_type'),
        );
    }
}
