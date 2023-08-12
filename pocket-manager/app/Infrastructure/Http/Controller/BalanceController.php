<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Entity\Person\Person;
use App\Domain\Entity\Pocket\Pocket;
use App\Http\Controllers\Controller;
use App\Service\BalanceService;

class BalanceController extends Controller
{
    public function __construct(
        private BalanceService $balanceService
    ) {
    }

    public function balance(Person $person, Pocket $pocket)
    {
        dd($person, $pocket);
    }

}
