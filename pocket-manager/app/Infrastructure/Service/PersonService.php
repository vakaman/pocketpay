<?php

namespace App\Infrastructure\Service;

use App\Domain\ValueObject\Email;
use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Exception\People\PersonDoesNotExistsException;
use App\Domain\Repository\PersonServiceInterface;
use App\Domain\ValueObject\Name;
use App\Infrastructure\Mapper\Api\People\Person as PeoplePerson;
use App\Infrastructure\Repository\PersonRepository;
use App\Service\WalletService;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;

class PersonService implements PersonServiceInterface
{
    public function __construct(
        private WalletService $walletService,
        private PersonRepository $personRepository
    ) {
    }

    public function getData(Transaction $transaction): Person
    {
        $person = $this->walletService->getPerson(new Wallet($transaction->from));

        $personData = $this->makeRequest($person);

        $responsePerson = new PeoplePerson(
            id: $person->id,
            name: new Name($personData->name),
            email: new Email($personData->email),
        );

        return Person::toEntity($responsePerson->toArray());
    }

    public function needExists(Person $person): PersonDoesNotExistsException|bool
    {
        if (!$this->personRepository->exists($person)) {
            throw new PersonDoesNotExistsException(person: $person);
        }

        return true;
    }

    private function makeRequest(Person $person)
    {
        try {
            $request = Http::get(
                env('API_POCKETPAY') . '/api/person/' . $person->id->value
            );

            if (!$request->ok()) {
                throw new HttpClientException();
            }

            return $request->object();
        } catch (HttpClientException $e) {
            throw $e;
        }
    }
}
