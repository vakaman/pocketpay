<?php

namespace App\Domain\Entity\People;

use App\Domain\ValueObject\Cpf;
use App\Domain\ValueObject\Email;

class PersonNatural
{
    public readonly string $name;
    public readonly Cpf $document;
    public readonly Email $email;

    public function __construct(
        string $name,
        Cpf $document,
        Email $email
    ) {
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
    }
}
