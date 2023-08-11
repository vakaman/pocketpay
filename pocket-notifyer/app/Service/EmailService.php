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
            $emailRequest->json('headers.subject'),
            $emailRequest->json('headers.date'),
            $emailRequest->json('headers.from'),
            $emailRequest->json('headers.sender'),
            $emailRequest->json('headers.to'),
            $emailRequest->json('headers.receiver'),
            $emailRequest->json('headers.reply_to')
        );
    }

    private function getBody(EmailRequest $emailRequest): Body
    {
        return new Body(
            $emailRequest->json('body.content_type'),
            $emailRequest->json('body.message'),
        );
    }
}
