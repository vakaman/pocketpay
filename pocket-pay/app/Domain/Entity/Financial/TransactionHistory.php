<?php

namespace App\Domain\Entity\Financial;

class TransactionHistory
{
    public function __construct(
        public readonly Transactions $values
    ) {
    }

    public static function toEntity(Transactions $transactions): TransactionHistory
    {
        return new self($transactions);
    }

    public static function fromEntity(TransactionHistory $transactionHistory): array
    {
        $arrayOftransactions = array_map(function ($transaction) {
            return Transaction::fromEntity($transaction);
        }, $transactionHistory->values->getTransactions());

        return $arrayOftransactions;
    }
}
