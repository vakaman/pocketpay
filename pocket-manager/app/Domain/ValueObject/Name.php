<?php

namespace App\Domain\ValueObject;

class Name
{
    public string $value;

    public function __construct(string $name)
    {
        $this->value = $this->verifyName($name);
    }

    private function verifyName(string $name): string
    {
        $sanitizedName = $this->sanitizeName($name);

        $this->validateName($sanitizedName);

        return $sanitizedName;
    }

    private function sanitizeName(string $name): string
    {
        return filter_var($name, FILTER_DEFAULT);
    }

    private function validateName(string $name): void
    {
        if (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ \'-]+$/', $name)) {
            throw new \Exception('The name provided is invalid');
        };
    }
}
