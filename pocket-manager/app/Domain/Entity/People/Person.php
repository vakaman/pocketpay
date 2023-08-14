<?php

namespace App\Domain\Entity\People;

use App\Domain\Entity\Email\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid;

class Person
{
    public readonly Uuid $id;
    public readonly Name|null $name;
    public readonly Email|null $email;

    public function __construct(Uuid $id, Name|null $name = null, Email|null $email = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public static function toEntity(array $model): Person
    {
        return new self(
            id: new Uuid($model['id'])
        );
    }

    public static function fromEntity(Person $person): array
    {
        return [
            "id" => $person->id->value,
            "name" => $person->name->value,
            "email" => $person->email->value
        ];
    }
}
