<?php

namespace App\Infrastructure\Repository;

use App\Domain\Repository\WalletRepositoryInterface;
use App\Models\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    public function belongsToPerson(string $wallet, string $person): bool
    {
        return Wallet::find($wallet)->person()->first()->exists();
    }
}
