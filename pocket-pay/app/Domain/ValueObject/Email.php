<?php

namespace App\Domain\ValueObject;

use App\Util\Sanitize;

class Email
{
    public readonly string $value;

    public function __construct(string $email)
    {
        $this->value = $this->sanitize($email);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function sanitize(string $email): string
    {
        return Sanitize::email($email);
    }
}
