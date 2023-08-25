<?php

namespace App\Infrastructure\Http\Api\Mapper\Pocket;

use App\Domain\Entity\People\PersonAbstract;

class CreateWallet
{
    public function __construct(
        private PersonAbstract $person
    ) {
    }

    public function toArray(): array
    {
        return [
            'person' => $this->person->id->value
        ];
    }
}
