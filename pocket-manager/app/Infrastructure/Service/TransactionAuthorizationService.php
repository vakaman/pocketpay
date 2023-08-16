<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Exception\Transaction\TransactionUnauthorized;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class TransactionAuthorizationService
{
    public function canTransact(Transaction $transaction): bool
    {
        $request = $this->makeRequest($transaction);

        if (!$request->ok()) {
            throw new TransactionUnauthorized($transaction);
        }

        return true;
    }

    private function makeRequest(Transaction $transaction): Response
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
}
