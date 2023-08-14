<?php

namespace App\Domain\Entity\Email;

use App\Util\Sanitize;

class Email
{
    public readonly string $value;

    public function __construct(string $email)
    {
        $this->value = Sanitize::email($email);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
