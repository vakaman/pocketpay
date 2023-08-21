<?php

namespace App\Domain\Entity\People;

use App\Domain\ValueObject\Uuid;
use App\Models\EconomicActivitie;
use Ramsey\Uuid\Uuid as UuidValidator;

class Person
{
    public readonly Uuid|string $id;
    public readonly Type $type;
    public readonly EconomicActivitie $economicActivitie;
    public readonly PersonLegal|PersonNatural $person;

    public function __construct(
        Uuid|string $id,
        Type $type,
        EconomicActivitie $economicActivitie,
        PersonLegal|PersonNatural $person
    ) {
        $this->id = $this->setId($id);
        $this->type = $type;
        $this->economicActivitie = $economicActivitie;
        $this->person = $person;
    }

    public static function toEntity(array $model): Person
    {
        return new self(
            id: $model['id'],
            type: $model['type'] ?? null,
            economicActivitie: $model['economicActivitie'] ?? null,
            person: $model['person'] ?? null,
        );
    }

    public static function fromEntity(Person $person): array
    {
        return [];
    }

    private function setId(Uuid|string $id): Uuid
    {
        if ($id instanceof Uuid) {
            return $id;
        }

        if (UuidValidator::isValid($id)) {
            return new Uuid($id);
        }
    }
}
