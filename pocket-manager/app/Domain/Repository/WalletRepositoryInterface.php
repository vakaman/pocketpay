<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\ValueObject\Uuid;

/**
 * @see \App\Infrastructure\Repository\WalletRepository
 */
interface WalletRepositoryInterface
{
    public function belongsToPerson(Uuid $wallet, Person $person): bool;

    public function exists(Wallet $wallet): bool;

    public function haveFunds(Uuid $wallet, Money $value): bool;

    public function getPerson(Wallet $wallet): Person
    ;
}
