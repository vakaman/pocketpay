<?php

namespace App\Service;

use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\People\Person;
use App\Domain\Repository\PersonRepositoryInterface;

class BalanceService
{
    public function __construct(
        private PersonRepositoryInterface $personRepository,
    ) {
    }

    public function getBalance(Person $person, Wallet $wallet): int
    {
        $personWallet = $this->personRepository->getWallet($person, $wallet);

        return $personWallet->money->toInt();
    }
}
