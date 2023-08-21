<?php

namespace App\Domain\Entity\People;

class Type
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
    ) {
    }
}
