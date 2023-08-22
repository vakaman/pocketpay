<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Enum\PersonTypeEnum;
use App\Domain\ValueObject\Cnpj;
use App\Domain\ValueObject\Cpf;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Uuid as ValueObjectUuid;
use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\PersonLegal;
use App\Models\PersonNatural;
use App\Models\User;
use App\Models\UserPerson;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validateRequest($request);

        $user = $this->createUser($request);

        $personUuid = Uuid::uuid4()->toString();

        $this->createPerson($request, $personUuid);

        $this->attachUserToPerson($user, $personUuid);

        $this->createPersonByType($request, $personUuid);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    private function validateRequest($request)
    {
        $request->validate([
            'personType' => ['required', 'int'],
            'economicActivities' => ['required', 'int'],
            'name' => ['required', 'string', 'max:255'],
            'document' => [
                'required',
                'string',
                'max:18',
                'unique:' . PersonLegal::class,
                'unique:' . PersonNatural::class,
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:' . User::class,
                'unique:' . PersonLegal::class,
                'unique:' . PersonNatural::class,
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    private function createUser($request)
    {
        return User::firstOrCreate(
            [
                'email' => (new Email($request->get('email')))->value,
            ],
            [
                'name' => (new Name($request->get('name')))->value,
                'email' => (new Email($request->get('email')))->value,
                'password' => Hash::make($request->password),
            ]
        );
    }

    private function createPerson($request, $uuid): Person
    {
        return Person::firstOrCreate(
            [
                'id' => (new ValueObjectUuid($uuid))->value
            ],
            [
                'id' => (new ValueObjectUuid($uuid))->value,
                'type_id' => $request->get('personType'),
                'economic_activities_id' => $request->get('economicActivities'),
            ],
        );
    }

    private function attachUserToPerson($user, $uuid): void
    {
        UserPerson::firstOrCreate(
            [
                'user_id' => $user->id,
                'person_id' => (new ValueObjectUuid($uuid))->value,
            ],
            [
                'user_id' => $user->id,
                'person_id' => (new ValueObjectUuid($uuid))->value,
            ]
        );
    }

    private function createPersonByType(Request $request, string $uuid): void
    {
        if (PersonTypeEnum::from($request->get('personType'))->name === 'PF') {
            $this->createPersonNatural($request, $uuid);
        }

        if (PersonTypeEnum::from($request->get('personType'))->name === 'PJ') {
            $this->createPersonLegal($request, $uuid);
        }
    }

    private function createPersonNatural(Request $request, string $uuid): void
    {
        PersonNatural::firstOrCreate(
            [
                'person_id' => (new ValueObjectUuid($uuid))->value,
                'document' => (new Cpf($request->get('document')))->value,
                'email' => (new Email($request->get('email')))->value,
            ],
            [
                'person_id' => (new ValueObjectUuid($uuid))->value,
                'name' => (new Name($request->get('name')))->value,
                'document' => (new Cpf($request->get('document')))->value,
                'email' => (new Email($request->get('email')))->value,
            ]
        );
    }

    private function createPersonLegal(string $uuid, Request $request): void
    {
        PersonLegal::firstOrCreate(
            [
                'person_id' => (new ValueObjectUuid($uuid))->value,
                'document' => (new Cnpj($request->get('document')))->value,
                'email' => (new Email($request->get('email')))->value,
            ],
            [
                'person_id' => (new ValueObjectUuid($uuid))->value,
                'name' => (new Name($request->get('name')))->value,
                'document' => (new Cnpj($request->get('document')))->value,
                'email' => (new Email($request->get('email')))->value,
            ]
        );
    }
}
