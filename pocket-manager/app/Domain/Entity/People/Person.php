<?php

namespace App\Domain\Entity\People;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid;
use Ramsey\Uuid\Uuid as UuidValidator;

class Person
{
    public readonly Uuid|string $id;
    public readonly Name|null $name;
    public readonly Email|null $email;

    public function __construct(Uuid|string $id, Name|null $name = null, Email|null $email = null)
    {
        $this->id = $this->setId($id);
        $this->name = $name;
        $this->email = $email;
    }

    public static function toEntity(array $model): Person
    {
        return new self(
            id: $model['id'],
            name: $model['name'] ?? null,
            email: $model['email'] ?? null,
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
