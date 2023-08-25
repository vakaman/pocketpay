<?php

namespace App\Service;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Exception\Wallet\WalletDontHaveFundsException;
use App\Domain\Exception\Wallet\WalletNotBelongsToPersonException;
use App\Domain\Exception\Wallet\WalletNotExistsException;
use App\Domain\Repository\PersonRepositoryInterface;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Service\Interfaces\WalletServiceInterface;

class WalletService implements WalletServiceInterface
{
    public function __construct(
        private PersonRepositoryInterface $personRepository,
        private WalletRepositoryInterface $walletRepository
    ) {
    }

    public function all(Person $person): Wallets
    {
        return $this->walletRepository->all($person);
    }

    public function main(Person $person): Wallet
    {
        $this->personRepository->needExists($person);

        return $this->walletRepository->main($person);
    }

    public function create(Person $person): Wallet
    {
        $this->personRepository->create($person);

        return $this->walletRepository->create($person, $this->hasMainWallet($person));
    }

    public function delete(Wallet $wallet): void
    {
        $this->walletRepository->delete($wallet);
    }

    public function setMain(Wallet $wallet): bool
    {
        $this->walletsExists(new Wallets([$wallet]));

        return $this->walletRepository->setMain($wallet);
    }

    public function belongsToPerson(Uuid $wallet, Person $person): bool
    {
        if (!$this->walletRepository->belongsToPerson($wallet, $person)) {
            throw new WalletNotBelongsToPersonException(wallet: $wallet, person: $person);
        }

        return true;
    }

    public function needExists(Wallet $wallet): bool|WalletNotExistsException
    {
        if (!$this->walletRepository->exists($wallet)) {
            throw new WalletNotExistsException(wallet: $wallet);
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
        $this->needExists($wallet);

        return $this->walletRepository->getPerson($wallet);
    }

    public function addFunds(Wallet $wallet, Money $money): int
    {
        $this->needExists($wallet);

        return $this->walletRepository->addFunds($wallet, $money);
    }

    private function hasMainWallet(Person $person): bool
    {
        return empty($this->walletRepository->main($person)) ? true : false;
    }
}
