<?php

namespace App\Domain\ValueObject;

use Ramsey\Uuid\Exception\InvalidUuidStringException;

class Uuid
{
    public string $value;

    public function __construct(string $uuid)
    {
        $this->value = $this->verifyUuid($uuid);
    }

    private function verifyUuid(string $uuid): string
    {
        if (!isUuid($uuid)) {
            throw new InvalidUuidStringException('Inválid Uuid value, uuid: ' . $uuid);
        }

        return $uuid;
    }
}
