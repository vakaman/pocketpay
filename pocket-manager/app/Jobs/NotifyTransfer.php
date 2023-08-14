<?php

namespace App\Jobs;

use App\Infrastructure\Http\Entity\Notification\Body;
use App\Infrastructure\Http\Entity\Notification\Headers;
use App\Domain\Entity\Financial\Transaction;
use App\Infrastructure\Http\Entity\Notification\Package;
use App\Infrastructure\Service\NotifyerService;
use App\Infrastructure\Service\PersonService;
use App\Service\WalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $maxExceptions = 5;

    public $timeout = 60;

    public function __construct(
        private Transaction $transaction,
        private NotifyerService $notifyerService,
        private WalletService $walletService,
        private PersonService $personService
    ) {
    }

    public function handle(): void
    {
        $fromPerson = $this->personService->getData($this->transaction);
        $toPerson = $this->personService->getData($this->transaction);

        $package = new Package(
            new Headers(
                subject: "Received Transfer",
                from: $fromPerson->email,
                sender: $fromPerson->name,
                to: $toPerson->email,
                receiver: $toPerson->name
            ),
            new Body("You receive a new transfer")
        );

        $this->notifyerService->pushPackage($package);
    }
}
