<?php

namespace App\Infrastructure\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Http\Entity\EmailRequest;
use App\Service\EmailService;

class EmailController extends Controller
{
    public function __construct(
        private EmailService $emailService
    ) {
    }

    public function send(EmailRequest $emailRequest)
    {
        $this->emailService->send($emailRequest);
    }
}
