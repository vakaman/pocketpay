<?php

namespace App\Domain\Entity\People;

use App\Domain\Enum\PersonTypeEnum;

class Type
{
    public readonly int $id;
    public readonly string|null $name;

    public function __construct(
        int $id,
        string|null $name = null
    ) {
        $this->id = $id;
        $this->name = $name ?? $this->getName($id);
    }

    private function getName(int $id): string
    {
        return PersonTypeEnum::from($id)->name;
    }
}
