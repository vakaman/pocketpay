<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\People\Person;
use App\Domain\Exception\People\PersonDoesNotExistsException;

/**
 * @see \App\Infrastructure\Service\PersonService
 */
interface PersonServiceInterface
{

    public function getData(Transaction $transaction): Person;

    public function needExists(Person $person): PersonDoesNotExistsException|bool;
}
