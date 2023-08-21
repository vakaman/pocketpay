<?php

namespace App\Domain\ValueObject;

use App\Util\Sanitize;

class Cpf
{
    public readonly string $value;

    public function __construct(string $cpf)
    {
        $this->value = $this->sanitize($cpf);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function sanitize(string $cpf): string
    {
        return Sanitize::cpf($cpf);
    }
}
