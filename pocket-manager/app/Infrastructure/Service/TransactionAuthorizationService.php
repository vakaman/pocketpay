<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Financial\Transaction;
use Illuminate\Support\Facades\Http;

class TransactionAuthorizationService
{
    public function __construct(
        private Http $request
    ) {
    }

    public function canTransact(Transaction $transaction): bool
    {
        $transaction = $this->request->post(
            env('TRANSACTION_AUTHORIZER_HOST') . '/canTransact',
            [
                'transaction' => $transaction->fromEntity($transaction)
            ]
        );

        return $transaction->accepted();
    }
}
