<?php

namespace App\Domain\Entity\Financial;

use App\Domain\Entity\Currency\Money;
use App\Domain\ValueObject\Uuid;
use Illuminate\Support\Carbon;

class Transaction
{
    public function __construct(
        public readonly Uuid $id,
        public readonly Uuid $from,
        public readonly Uuid $to,
        public readonly Money $value,
        public readonly Carbon $created_at,
        public readonly Carbon $updated_at
    ) {
    }

    public static function toEntity(array $model): Transaction
    {
        return new self(
            new Uuid($model['id']),
            new Uuid($model['from']),
            new Uuid($model['to']),
            new Money($model['value']),
            new Carbon($model['created_at']),
            new Carbon($model['updated_at'])
        );
    }

    public static function fromEntity(Transaction $transaction): array
    {
        return [
            "id" => $transaction->id->value,
            "from" => $transaction->from->value,
            "to" => $transaction->to->value,
            "value" => $transaction->value->toInt(),
            "created_at" => $transaction->created_at->format('Y-m-d H:i:s'),
            "updated_at" => $transaction->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
