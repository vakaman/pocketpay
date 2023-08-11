<?php

namespace App\Jobs;

use App\Domain\Entity\Email\Envelope;
use App\Mail\MailEnvelope;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $maxExceptions = 5;

    public $timeout = 60;

    public function __construct(
        private Envelope $envelope
    ) {
    }

    public function handle(): void
    {
        try {
            Mail::to($this->envelope->header->to)->send(
                new MailEnvelope($this->envelope)
            );
        } catch (TransportException $e) {
            $this->release(60);
        }
    }
}
