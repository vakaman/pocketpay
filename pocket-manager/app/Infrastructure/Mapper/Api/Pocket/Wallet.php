<?php

namespace App\Infrastructure\Mapper\Api\Pocket;

use App\Domain\Entity\Pocket\Wallet as PocketWallet;

class Wallet
{
    public function __construct(
        private PocketWallet $wallet
    ) {
    }

    public function request(): array
    {
        return [
            'id' => $this->wallet->id->value,
            'money' => $this->wallet->money->toInt(),
            'main' => $this->wallet->main
        ];
    }
}
