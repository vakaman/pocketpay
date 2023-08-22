<?php

namespace App\Domain\ValueObject;

class Email
{
    public readonly string $value;

    public function __construct(string $email)
    {
        $this->value = $this->setEmail($email);
    }

    private function setEmail(string $email): string
    {
        $validEmail = $this->validateEmail($email);

        return trim($validEmail);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function validateEmail(string $email): string
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('The email provided is invalid');
        };

        return $email;
    }
}
