<?php

namespace App\Domain\Entity\People;

use App\Domain\ValueObject\Cpf;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid;

class PersonNatural extends Person
{
    public readonly Name $name;
    public readonly Cpf $document;
    public readonly Email $email;

    public function __construct(
        Uuid|string $id,
        Type $type,
        Name $name,
        Cpf $document,
        Email $email
    ) {
        parent::__construct(id: $id, type: $type);
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
    }

    public static function toEntity(array $model): Person
    {
        return new self(
            id: new Uuid($model['id']),
            type: new Type(id: $model['type_id']),
            name: new Name(name: $model['natural']['name']),
            document: new Cpf(cpf: $model['natural']['document']),
            email: new Email(email: $model['natural']['email']),
        );
    }

    public static function fromEntity(Person $person): array
    {
        return [];
    }
}
