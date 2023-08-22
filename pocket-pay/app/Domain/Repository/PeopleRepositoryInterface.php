<?php

namespace App\Domain\Repository;

use App\Domain\Entity\People\PersonLegal;
use App\Domain\Entity\People\PersonNatural;
use App\Domain\ValueObject\Uuid;

/**
 * @see \App\Infrastructure\Repository\PeopleRepository
 */
interface PeopleRepositoryInterface
{
    public function get(Uuid $id): PersonLegal|PersonNatural;
}
