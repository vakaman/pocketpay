<?php

namespace App\Domain\ValueObject;

use App\Util\Sanitize;

class Email
{
    public string $value;

    public function __construct(string $email)
    {
        $this->value = $this->validateEmail(Sanitize::email($email));
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('The email provided is invalid');
        };
    }
}