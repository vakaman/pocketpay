<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Service\WalletService;
use Illuminate\Support\Facades\Http;

class PersonService
{
    public function __construct(
        private Http $request,
        private WalletService $walletService
    ) {
    }

    public function getData(Transaction $transaction): Person
    {
        $person = $this->walletService->getPerson(
            new Wallet($transaction->from)
        );

        $responsePerson = $this->request->get(
            env('API_POCKETPAY') . '/api/person/' . $person->id
        )->json();

        return Person::toEntity(json_decode($responsePerson, true));
    }
}
