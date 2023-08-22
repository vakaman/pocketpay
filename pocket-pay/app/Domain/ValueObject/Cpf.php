<?php

namespace App\Domain\ValueObject;

class Cpf
{
    public readonly string $value;

    public function __construct(string $cpf)
    {
        $this->value = $this->setCpf($cpf);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function setCpf(string $cpf): string
    {
        $this->validate($cpf);

        return trim(preg_replace('/[^0-9]/', '', $cpf));
    }

    private function validate(string $cpf): void
    {
        if (!validateCpf($cpf)) {
            throw new \Exception('The CPF value is invalid');
        };
    }
}
