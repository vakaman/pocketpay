<?php

namespace App\Infrastructure\Http\Api\Mapper\Financial;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory as FinancialTransactionHistory;
use App\Domain\Entity\Financial\Transactions;

class TransactionHistory
{
    public static function fromArray(array $transactionHistory): FinancialTransactionHistory
    {
        $transactions = new Transactions(array_map(function ($transaction) {

            $id = array_key_first($transaction);
            $data = $transaction[$id];

            return Transaction::toEntity(
                [
                    'id' => $id,
                    'status_id' => $data['status_id'],
                    'from' => $data['from'],
                    'to' => $data['to'],
                    'value' => $data['value'],
                    'created_at' => $data['created_at'],
                    'updated_at' => $data['updated_at'],
                ]
            );
        }, $transactionHistory));

        return new FinancialTransactionHistory($transactions);
    }

    public static function toArray(FinancialTransactionHistory $transactionHistory): array
    {
        return array_map(function ($transaction) {

            $transaction = Transaction::fromEntity($transaction);
            return [
                "{$transaction['id']}" => [
                    'status' => $transaction['status'],
                    'from' => $transaction['from'],
                    'to' => $transaction['to'],
                    'value' => $transaction['value'],
                    'created_at' => $transaction['created_at'],
                    'updated_at' => $transaction['updated_at']
                ]
            ];
        }, $transactionHistory->values->getTransactions());
    }
}
