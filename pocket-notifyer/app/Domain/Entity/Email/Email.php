<?php

namespace App\Domain\Entity\Email;

use App\Util\Sanitize;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = Sanitize::email($email);
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
