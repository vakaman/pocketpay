<?php

namespace App\Domain\Entity\EconomicActivities;

use App\Domain\Entity\People\Type;

class EconomicActivities
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly Code $code,
        public readonly Type $type
    ) {
    }
}
