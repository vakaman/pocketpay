<?php

namespace App\Infrastructure\Mapper\Api\Pocket;

use App\Domain\Entity\Pocket\Wallets as PocketWallets;

class Wallets
{
    public function __construct(
        private PocketWallets $wallets
    ) {
    }

    public function request(): array
    {
        return $this->wallets->toArray();
    }
}
