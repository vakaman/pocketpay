<?php

namespace App\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Http\Entity\EmailRequest;
use App\Infrastructure\Http\Entity\StatusCode;
use App\Service\EmailService;
use Illuminate\Http\Response;

class EmailController extends Controller
{
    public function __construct(
        private EmailService $emailService
    ) {
    }

    public function send(EmailRequest $emailRequest): Response
    {
        $this->emailService->send($emailRequest);

        return response()->noContent(StatusCode::CREATED->value);
    }
}
