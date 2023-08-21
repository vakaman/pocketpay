<?php

namespace App\Domain\ValueObject;

use App\Util\Sanitize;

class Cnpj
{
    public readonly string $value;

    public function __construct(string $cnpj)
    {
        $this->value = $this->sanitize($cnpj);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function sanitize(string $cnpj): string
    {
        return Sanitize::cnpj($cnpj);
    }
}
