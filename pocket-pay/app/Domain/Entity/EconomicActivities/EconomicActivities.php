<?php

namespace App\Domain\Entity\EconomicActivities;

use App\Domain\Entity\People\Type;

class EconomicActivities
{
    public function __construct(
        public readonly int $id,
        public readonly Type $type,
        public readonly string|null $name,
        public readonly Code|null $code
    ) {
    }
}
