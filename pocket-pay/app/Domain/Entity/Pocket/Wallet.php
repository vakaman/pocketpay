<?php

namespace App\Domain\Entity\Pocket;

use App\Domain\Entity\Currency\Money;
use App\Domain\ValueObject\Uuid;

class Wallet
{
    public readonly Uuid $id;
    public readonly Money $money;
    public readonly bool $main;

    public function __construct(
        ?Uuid $id = null,
        ?Money $money = null,
        ?bool $main = null
    ) {
        $this->id = $id ?? new Uuid(uuidGenerate());
        $this->money = $money ?? new Money(0);
        $this->main = $main ?? false;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'money' => $this->money->toInt(),
            'main' => $this->main
        ];
    }

    public static function toEntity(array $model): Wallet
    {
        return new self(
            id: new Uuid($model['id']),
            money: new Money($model['money']),
            main: (bool) $model['main']
        );
    }

    public static function fromEntity(Wallet $wallet): array
    {
        return [
            "id" => $wallet->id->value,
            "money" => $wallet->money->toInt(),
            "main" => $wallet->main
        ];
    }
}
