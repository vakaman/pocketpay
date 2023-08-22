<?php

namespace App\Domain\ValueObject;

class Cnpj
{
    public readonly string $value;

    public function __construct(string $cnpj)
    {
        $this->value = $this->setCnpj($cnpj);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function setCnpj(string $cnpj): string
    {
        $this->validate($cnpj);

        return trim(preg_replace('/[^0-9]/', '', $cnpj));
    }

    private function validate(string $cnpj): void
    {
        if (!validateCpf($cnpj)) {
            throw new \Exception('The CPF value is invalid');
        };
    }
}
