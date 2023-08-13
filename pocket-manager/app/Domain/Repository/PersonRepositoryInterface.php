<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\People\Person;

/**
 * @see \App\Infrastructure\Repository\PersonRepository
 */
interface PersonRepositoryInterface
{
    public function getWallet(Person $person, Wallet $wallet): Wallet;
}
