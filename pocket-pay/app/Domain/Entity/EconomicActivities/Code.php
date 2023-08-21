<?php

namespace App\Domain\Entity\EconomicActivities;

class Code
{
    public function __construct(
        public readonly string $code
    ) {
    }
}
