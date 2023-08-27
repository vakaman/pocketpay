<?php

namespace App\Infrastructure\Mapper\Api;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory as FinancialTransactionHistory;

class TransactionHistory
{
    public function __construct(
        private FinancialTransactionHistory $transactionHistory
    ) {
    }

    public function toArray(): array
    {
        return array_map(function ($transaction) {

            $transaction = Transaction::fromEntity($transaction);
            return [
                "{$transaction['id']}" => [
                    'status_id' => $transaction['status_id'],
                    'from' => $transaction['from'],
                    'to' => $transaction['to'],
                    'value' => $transaction['value'],
                    'created_at' => $transaction['created_at'],
                    'updated_at' => $transaction['updated_at']
                ]
            ];
        }, $this->transactionHistory->values->getTransactions());
    }
}
