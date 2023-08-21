<?php

namespace App\Domain\Entity\People;

use App\Domain\ValueObject\Cnpj;
use App\Domain\ValueObject\Email;

class PersonLegal
{
    public readonly string $name;
    public readonly Cnpj $document;
    public readonly Email $email;

    public function __construct(
        string $name,
        Cnpj $document,
        Email $email
    ) {
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
    }
}
