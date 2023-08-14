<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet as PocketWallet;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WalletRepository implements WalletRepositoryInterface
{
    public function belongsToPerson(Uuid $walletUuid, Person $person): bool
    {
        $wallet = Wallet::where('id', $walletUuid->value)->first();

        if ($wallet) {
            return $wallet->person()->where('id', $person->id)->exists();
        }

        return false;
    }

    public function exists(PocketWallet $wallet): bool
    {
        return Wallet::where('id', $wallet->id->value)->exists();
    }

    public function haveFunds(Uuid $wallet, Money $value): bool
    {
        return Wallet::where('id', $wallet)
            ->where('value', '>=', $value->toInt())
            ->exists();
    }

    public function getPerson(PocketWallet $wallet): Person
    {
        if (!$this->exists($wallet)) {
            throw new ModelNotFoundException;
        }

        $person = Wallet::find($wallet)->person()->first()->toArray();

        if (!$person) {
            throw new ModelNotFoundException;
        }

        return Person::toEntity($person);
    }
}
