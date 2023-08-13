<?php

namespace App\Domain\Repository;

/**
 * @see \App\Infrastructure\Repository\WalletRepository
 */
interface WalletRepositoryInterface
{
    public function belongsToPerson(string $wallet, string $person): bool;
}
