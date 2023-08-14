<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Financial\Transaction;
use App\Infrastructure\Http\Entity\Notification\Package;
use App\Jobs\NotifyTransfer;
use Illuminate\Support\Facades\Http;

class NotifyerService
{
    public function __construct(
        private Http $request
    ) {
    }

    public function send(Transaction $transaction): void
    {
        NotifyTransfer::dispatch($transaction);
    }

    public function pushPackage(Package $package): void
    {
        $this->request->post(
            env('API_NOTIFYER') . '/api/email',
            [
                'headers' => $package->headers->toArray(),
                'boyd' => $package->body->toArray()
            ]
        );
    }
}
