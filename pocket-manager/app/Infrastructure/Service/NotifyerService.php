<?php

namespace App\Infrastructure\Service;

use App\Infrastructure\Http\Entity\Notification\Body;
use App\Infrastructure\Http\Entity\Notification\Headers;
use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\People\Person;
use App\Domain\Repository\PersonServiceInterface;
use App\Infrastructure\Http\Entity\Notification\Package;

use App\Jobs\NotifyTransfer;
use App\Service\Interfaces\NotifyerServiceInterface;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;

class NotifyerService implements NotifyerServiceInterface
{
    public function __construct(
        private PersonServiceInterface $personService
    ) {
    }

    public function send(Package $package): bool
    {
        $notificationWasSent = NotifyTransfer::dispatch($package);

        if ($notificationWasSent) {
            return true;
        }

        return false;
    }

    public function pushPackage(Package $package): bool
    {
        try {
            $transaction = Http::post(
                env('API_NOTIFYER') . '/api/email',
                [
                    'headers' => $package->headers->toArray(),
                    'body' => $package->body->toArray()
                ]
            );

            if (!$transaction->ok() && !$transaction->created()) {
                throw new HttpClientException;
            }

            return true;
        } catch (HttpClientException $e) {
            throw $e;
        }
    }

    public function notificationPackage(Transaction $transaction): Package
    {
        return $this->getEmailPackage(
            $transaction,
            $this->personService->getData($transaction),
            $this->personService->getData($transaction),
        );
    }

    private function getEmailPackage(Transaction $transaction, Person $from, Person $to): Package
    {
        return new Package(
            new Headers(
                subject: "Received Transfer",
                from: $from->email,
                sender: $from->name,
                to: $to->email,
                receiver: $to->name,
                money: $transaction->value,
            ),
            new Body(
                sprintf(
                    'You have received a new transfer in the amount of %s from: %s',
                    $transaction->value->toReal(),
                    $from->name->value
                )
            )
        );
    }
}
