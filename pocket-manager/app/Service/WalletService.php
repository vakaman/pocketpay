<?php

namespace App\Service;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Exception\WalletDontHaveFundsException;
use App\Domain\Exception\WalletNotBelongsToPersonException;
use App\Domain\Exception\WalletNotExistsException;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;

class WalletService
{
    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {
    }

    public function belongsToPerson(Uuid $wallet, Person $person): bool
    {
        if (!$this->walletRepository->belongsToPerson($wallet, $person)) {
            throw new WalletNotBelongsToPersonException($wallet);
        }

        return true;
    }

    public function walletsExists(Wallets $wallets): bool|WalletNotExistsException
    {
        foreach ($wallets as $wallet) {
            if (!$this->walletRepository->exists($wallet)) {
                throw new WalletNotExistsException(wallet: $wallet);
            }
        }

        return true;
    }

    public function haveFunds(Uuid $wallet, Money $value): bool|WalletDontHaveFundsException
    {
        if (!$this->walletRepository->haveFunds($wallet, $value)) {
            throw new WalletDontHaveFundsException($wallet);
        }

        return true;
    }

    public function getPerson(Wallet $wallet): Person
    {
        return $this->walletRepository->getPerson($wallet);
    }
}
