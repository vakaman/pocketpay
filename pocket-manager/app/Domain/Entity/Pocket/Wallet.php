<?php

namespace App\Domain\Entity\Pocket;

use App\Domain\Entity\Currency\Money;

class Wallet
{
    public function __construct(
        public readonly string $id,
        public readonly Money $money = new Money(0),
        public readonly bool $main = false
    ) {
    }

    public static function toEntity(array $model): Wallet
    {
        return new self(
            id: $model['id'],
            money: $model['money'],
            main: (bool) $model['main']
        );
    }

    public static function fromEntity(Wallet $wallet): array
    {
        return [
            "id" => $wallet->id,
            "money" => $wallet->money->toInt(),
            "main" => $wallet->main
        ];
    }
}
