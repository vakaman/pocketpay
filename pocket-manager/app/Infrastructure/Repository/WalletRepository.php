<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet as PocketWallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Exception\Wallet\WalletCannotBeCreatedException;
use App\Domain\Repository\PersonRepositoryInterface;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Models\Person as ModelsPerson;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WalletRepository implements WalletRepositoryInterface
{
    public function __construct(
        private PersonRepositoryInterface $personRepository
    ) {
    }

    public function all(Person $person): Wallets
    {
        return Wallets::toEntityes(
            Wallet::whereIn('id', $this->personRepository->wallets($person))
                ->get()
                ->toArray()
        );
    }

    public function main(Person $person): PocketWallet|bool
    {
        $wallet = Wallet::where('main', true)
            ->whereIn(
                'id',
                ($this->all($person))->ids()
            )
            ->get()
            ->first();

        if ($wallet) {
            return PocketWallet::toEntity($wallet->toArray());
        }

        return false;
    }

    public function create(Person $person, bool $main): PocketWallet
    {
        $newPerson = ModelsPerson::find($person->id->value);

        $createdWallet = Wallet::factory()
            ->main($main)
            ->hasAttached($newPerson)
            ->create();

        if ($createdWallet) {
            return PocketWallet::toEntity($createdWallet->toArray());
        }

        throw new WalletCannotBeCreatedException($person);
    }

    public function delete(PocketWallet $wallet): void
    {
        Wallet::findOrFail($wallet->id->value)->delete();
    }

    public function setMain(PocketWallet $wallet): bool
    {
        $wallet = Wallet::find($wallet->id->value);
        $person = new Person(new Uuid($wallet->people()->first()->id));
        $actualMainWallet = $this->main($person);

        if ($actualMainWallet && $wallet->id != $actualMainWallet->id->value) {
            Wallet::where('id', $actualMainWallet->id->value)
                ->update([
                    'main' => false
                ]);
        }

        return $wallet->update([
            'main' => true
        ]);
    }

    public function belongsToPerson(Uuid $walletUuid, Person $person): bool
    {
        $wallet = Wallet::where('id', $walletUuid->value)->first();

        if ($wallet) {
            return $wallet->people()->where('id', $person->id->value)->exists();
        }

        return false;
    }

    public function exists(PocketWallet $wallet): bool
    {
        return Wallet::where('id', $wallet->id->value)->exists();
    }

    public function haveFunds(Uuid $wallet, Money $value): bool
    {
        return Wallet::where('id', $wallet->value)
            ->where('money', '>=', $value->toInt())
            ->exists();
    }

    public function getPerson(PocketWallet $wallet): Person
    {
        if (!$this->exists($wallet)) {
            throw new ModelNotFoundException;
        }

        $person = Wallet::find($wallet->id->value)->people()->first()->toArray();

        if (!$person) {
            throw new ModelNotFoundException;
        }

        return Person::toEntity($person);
    }

    public function addFunds(PocketWallet $wallet, Money $money): int
    {
        return Wallet::where('id', $wallet->id->value)
            ->increment('money', $money->toInt());
    }

    public function subtractfunds(PocketWallet $wallet, Money $money): int
    {
        return Wallet::where('id', $wallet->id->value)
            ->decrement('money', $money->toInt());
    }
}
