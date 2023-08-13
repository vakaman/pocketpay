<?php

namespace App\Service;

use App\Domain\Repository\WalletRepositoryInterface;

class WalletService
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {
    }

    public function belongsToPerson(string $wallet, string $person): void
    {
        if (!$this->walletRepository->belongsToPerson($wallet, $person)) {
            throw new \Exception('The wallet not belongs to person');
        }
    }
}
