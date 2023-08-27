<?php

namespace App\Infrastructure\Http\Api\Mapper\Financial;

use App\Domain\Entity\Financial\Transaction as FinancialTransaction;

class Transaction
{
    public function __construct(
        private FinancialTransaction $transaction
    ) {
    }

    public function toArray(): array
    {
        return [
            'transaction' => [
                'id' => $this->transaction->id->value,
                'status' => $this->transaction->status,
                'from' => $this->transaction->from->value,
                'to' => $this->transaction->to->value,
                'value' => $this->transaction->value->toInt(),
                'created_at' => $this->transaction->createdAt,
                'updated_at' => $this->transaction->updatedAt,
            ]
        ];
    }
}
