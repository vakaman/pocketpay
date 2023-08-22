<?php

namespace App\Domain\Entity\People;

use App\Domain\Entity\EconomicActivities\EconomicActivities;
use App\Domain\ValueObject\Cnpj;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid;

class PersonLegal extends Person
{
    public readonly Name $name;
    public readonly Cnpj $document;
    public readonly Email $email;
    public readonly EconomicActivities $economicActivities;

    public function __construct(
        Uuid|string $id,
        Type $type,
        Name $name,
        Cnpj $document,
        Email $email,
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
            name: new Name(name: $model['legal']['name']),
            document: new Cnpj(cnpj: $model['legal']['document']),
            email: new Email(email: $model['legal']['email'])
        );
    }

    // public static function fromEntity(Person $person): array
    // {
    //     return [];
    // }
}
