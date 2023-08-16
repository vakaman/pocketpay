<?php

namespace App\Infrastructure\Mapper\Api\People;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid;

class Person
{
    public function __construct(
        public readonly Uuid $id,
        public readonly Name $name,
        public readonly Email $email
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
