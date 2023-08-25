<?php

namespace App\Infrastructure\Http\Api\Mapper\Pocket;

use App\Domain\Entity\Pocket\Wallets as PocketWallets;

class Wallets
{
    public function __construct(
        private PocketWallets $wallets
    ) {
    }

    public function toArray(): array
    {
        return $this->wallets->toArray();
    }
}
