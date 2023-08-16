<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Exception\Transaction\TransactionUnauthorizedException;
use App\Service\Interfaces\TransactionAuthorizationServiceInterface;
use App\Service\Interfaces\WalletServiceInterface;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class TransactionAuthorizationService implements TransactionAuthorizationServiceInterface
{
    public function __construct(
        private WalletServiceInterface $walletService
    ) {
    }

    public function canTransact(Transaction $transaction): bool
    {
        $request = $this->canTransactRequest($transaction);

        if (!$request->ok()) {
            throw new TransactionUnauthorizedException($transaction);
        }

        return true;
    }

    public function personCanTransferFunds(Transaction $transaction): bool
    {
        $person = $this->walletService->getPerson(
            new Wallet($transaction->from)
        );

        $request = $this->canTransferFundsRequest($person);

        if (!$request->accepted()) {
            throw new TransactionUnauthorizedException($transaction);
        }

        return true;
    }

    private function canTransactRequest(Transaction $transaction): Response
    {
        try {
            return Http::post(
                env('TRANSACTION_AUTHORIZER_HOST') . '/api/can-transact',
                [
                    'transaction' => $transaction->fromEntity($transaction)
                ]
            );
        } catch (HttpClientException $e) {
            throw $e;
        }
    }

    private function canTransferFundsRequest(Person $person): Response
    {
        try {
            return Http::post(
                env('API_POCKETPAY') . '/api/can-do-transfer',
                [
                    'person' => $person->id->value
                ]
            );
        } catch (HttpClientException $e) {
            throw $e;
        }
    }
}
