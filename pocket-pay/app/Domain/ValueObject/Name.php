<?php

namespace App\Domain\ValueObject;

class Name
{
    public string $value;

    public function __construct(string $name)
    {
        $this->value = $this->setName($name);
    }

    private function setName(string $name): string
    {
        $sanitizedName = $this->sanitizeName($name);

        $this->validateName($sanitizedName);

        $upperName = $this->setToUpper($name);

        return trim($upperName);
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

    private function setToUpper(string $name): string
    {
        return mb_strtoupper($name);
    }
}
