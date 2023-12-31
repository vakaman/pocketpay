<?php

namespace App\Domain\Entity\People;

use App\Domain\ValueObject\Uuid;

abstract class PersonAbstract
{
    public readonly Uuid|string $id;
    public readonly Type $type;

    public function __construct(
        Uuid|string $id,
        Type $type
    ) {
        $this->id = $this->setId($id);
        $this->type = $type;
    }

    private function setId(Uuid|string $id): Uuid
    {
        if ($id instanceof Uuid) {
            return $id;
        }

        return new Uuid($id);
    }
}
