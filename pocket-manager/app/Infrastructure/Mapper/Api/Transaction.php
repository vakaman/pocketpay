<?php

namespace App\Infrastructure\Mapper\Api;

use App\Domain\Entity\Financial\Transaction as FinancialTransaction;

class Transaction
{
    public function __construct(
        private FinancialTransaction $transaction
    ) {
    }

    public function response(): array
    {
        return [
            'transaction' => [
                'id' => $this->transaction->id->value,
                'from' => $this->transaction->from->value,
                'to' => $this->transaction->to->value,
                'value' => $this->transaction->value->toInt(),
                'created_at' => $this->transaction->createdAt,
                'updated_at' => $this->transaction->updatedAt,
            ]
        ];
    }
}
