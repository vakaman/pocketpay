<?php

namespace App\Domain\Entity\Pocket;

use App\Domain\Entity\Currency\Money;
use App\Domain\ValueObject\Uuid;
use Ramsey\Uuid\Uuid as UuidGenerator;

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
        $this->id = $id ?? new Uuid((UuidGenerator::uuid4())->toString());
        $this->money = $money ?? new Money(0);
        $this->main = $main ?? false;
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
            "id" => $wallet->id,
            "money" => $wallet->money->toInt(),
            "main" => $wallet->main
        ];
    }
}
