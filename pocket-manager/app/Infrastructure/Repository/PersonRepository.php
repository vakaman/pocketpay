<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\People\Person;
use App\Domain\Repository\PersonRepositoryInterface;
use App\Models\Person as ModelsPerson;

class PersonRepository implements PersonRepositoryInterface
{
    public function getWallet(Person $person, Wallet $wallet): Wallet
    {
        $personWallet = ModelsPerson::with('wallets')
            ->where('id', $person->id)
            ->first()
            ->wallets()
            ->findOrFail($wallet->id);

        return Wallet::toEntity($personWallet->toArray());
    }
}
