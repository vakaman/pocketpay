<?php

namespace App\Http\Middleware;

use App\Domain\Entity\People\Person;
use App\Domain\Entity\People\Type;
use App\Domain\Repository\PeopleRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LoggedUserSession
{
    public function __construct(
        private PeopleRepositoryInterface $peopleRepository
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            $person = Person::new(
                id: new Uuid($user->person()->first()->id),
                type: new Type($user->person()->first()->type_id)
            );

            Session::put([
                'person' => $person
            ]);
        }

        return $next($request);
    }
}
