<?php

namespace App\Service\Interfaces;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Exception\Wallet\WalletDontHaveFundsException;
use App\Domain\Exception\Wallet\WalletNotExistsException;
use App\Domain\ValueObject\Uuid;

/**
 * @see \App\Service\WalletService
 */
interface WalletServiceInterface
{
    function all(Person $person): Wallets;

    public function main(Person $person): Wallet;

    public function create(Person $person): Wallet;

    public function setMain(Wallet $wallet): bool;

    public function belongsToPerson(Uuid $wallet, Person $person): bool;

    public function needExists(Wallet $wallet): bool|WalletNotExistsException;

    public function walletsExists(Wallets $wallets): bool|WalletNotExistsException;

    public function haveFunds(Uuid $wallet, Money $value): bool|WalletDontHaveFundsException;

    public function getPerson(Wallet $wallet): Person;

    public function addFunds(Wallet $wallet, Money $money): int;
}
