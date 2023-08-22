<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\People\PersonLegal;
use App\Domain\Entity\People\PersonNatural;
use App\Domain\Enum\PersonTypeEnum;
use App\Domain\Repository\PeopleRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Models\Person as ModelsPerson;

class PeopleRepository implements PeopleRepositoryInterface
{
    public function get(Uuid $id): PersonLegal|PersonNatural
    {
        $modelPerson = ModelsPerson::findOrFail($id->value);

        if (PersonTypeEnum::from($modelPerson->type_id)->name === 'PF') {
            $modelPersonDetail = $modelPerson->with('natural');

            return PersonNatural::toEntity(
                $modelPersonDetail->first()->toArray()
            );
        }

        if (PersonTypeEnum::from($modelPerson->type_id)->name === 'PJ') {
            $modelPersonDetail = $modelPerson->with('legal');

            return PersonLegal::toEntity(
                $modelPersonDetail->first()->toArray()
            );
        }
    }

}
