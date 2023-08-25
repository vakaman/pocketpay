<?php

namespace App\Domain\Entity\People;

use App\Domain\Entity\EconomicActivities\EconomicActivities;
use App\Domain\ValueObject\Cnpj;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid;

class PersonLegal extends PersonAbstract
{
    public readonly Name|null $name;
    public readonly Cnpj|null $document;
    public readonly Email|null $email;
    public readonly EconomicActivities|null $economicActivities;

    public function __construct(
        Uuid|string $id,
        Type $type,
        Name|null $name = null,
        Cnpj|null $document = null,
        Email|null $email = null,
        EconomicActivities|null $economicActivities = null
    ) {
        parent::__construct(id: $id, type: $type);
        $this->name = $name;
        $this->document = $document;
        $this->email = $email;
        $this->economicActivities = $economicActivities;
    }

    public static function toEntity(array $model): PersonAbstract
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
