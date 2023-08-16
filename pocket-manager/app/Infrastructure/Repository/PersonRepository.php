<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\People\Person;
use App\Domain\Repository\PersonRepositoryInterface;
use App\Models\Person as ModelsPerson;
use App\Models\PersonWallet;

class PersonRepository implements PersonRepositoryInterface
{
    public function create(Person $person): Person
    {
        return Person::toEntity(
            ModelsPerson::firstOrCreate(
                ['id' => $person->id->value],
                ['id' => $person->id->value]
            )->toArray()
        );
    }

    public function getWallet(Person $person, Wallet $wallet): Wallet
    {
        $personWallet = ModelsPerson::with('wallets')
            ->where('id', $person->id->value)
            ->first()
            ->wallets()
            ->findOrFail($wallet->id->value);

        return Wallet::toEntity($personWallet->toArray());
    }

    public function wallets(Person $person): array
    {
        return array_map(function ($uuid) {
            return $uuid;
        }, array_column(
            PersonWallet::where('person_id', $person->id->value)
                ->get()->toArray(),
            'wallet_id'
        ));
    }

    public function exists(Person $person): bool
    {
        return ModelsPerson::where('id', $person->id->value)->exists();
    }
}
