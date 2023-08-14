<?php

namespace App\Infrastructure\Mapper\People;

use App\Domain\Entity\Email\Email;
use App\Domain\ValueObject\Name;

class Person
{
    public function __construct(
        public readonly Name $name,
        public readonly Email $email
    ) {
    }
}
