<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\ValueObject\Uuid;

/**
 * @see \App\Infrastructure\Repository\WalletRepository
 */
interface WalletRepositoryInterface
{
    public function all(Person $person): Wallets;

    public function main(Person $person): Wallet|bool;

    public function create(Person $person, bool $main): bool;

    public function belongsToPerson(Uuid $wallet, Person $person): bool;

    public function exists(Wallet $wallet): bool;

    public function haveFunds(Uuid $wallet, Money $value): bool;

    public function getPerson(Wallet $wallet): Person;

    public function setMain(Wallet $wallet): bool;

    public function addFunds(Wallet $wallet, Money $money): int;

    public function subtractfunds(Wallet $wallet, Money $money): int;
}
