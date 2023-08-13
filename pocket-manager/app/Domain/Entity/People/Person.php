<?php

namespace App\Domain\Entity\People;

class Person
{
    public function __construct(
        public readonly string $id
    )
    {
    }
}
