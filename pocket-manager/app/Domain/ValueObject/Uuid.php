<?php

namespace App\Domain\ValueObject;

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
            throw new \Exception('Inválid Uuid value');
        }

        return $uuid;
    }
}
