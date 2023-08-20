<?php

namespace App\Http\Controllers\Auth;

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
            ['email' => $request->email,],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
    }

    private function createPerson($request, $personUuid): Person
    {
        return Person::firstOrCreate(
            ['id' => $personUuid],
            [
                'id' => $personUuid,
                'type_id' => $request->get('personType'),
                'economic_activities_id' => $request->get('economicActivities'),
            ],
        );
    }

    private function attachUserToPerson($user, $personUuid)
    {
        UserPerson::firstOrCreate(
            [
                'user_id' => $user->id,
                'person_id' => $personUuid,
            ],
            [
                'user_id' => $user->id,
                'person_id' => $personUuid,
            ]
        );
    }
}
