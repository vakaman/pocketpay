<?php

namespace App\Domain\Entity\People;

use App\Domain\ValueObject\Uuid;

class Person
{
    private static function personNatural($id, $type, ...$args): PersonAbstract
    {
        return new PersonNatural(
            $id,
            $type,
            ...$args
        );
    }

    private static function personLegal($id, $type, ...$args): PersonAbstract
    {
        return new PersonLegal(
            $id,
            $type,
            ...$args
        );
    }

    public static function new(Uuid $id, Type $type, ...$args): PersonAbstract
    {
        return match ($type->name) {
            'PF' => self::personNatural($id, $type, ...$args),
            'PJ' => self::personLegal($id, $type, ...$args),
        };
    }
}
