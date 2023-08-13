<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet as PocketWallet;
use App\Http\Controllers\Controller;
use App\Infrastructure\Mapper\Api\Balance;
use App\Service\BalanceService;
use Illuminate\Http\JsonResponse;

class BalanceController extends Controller
{
    public function __construct(
        private BalanceService $balanceService
    ) {
    }

    public function balance(string $person, string $wallet): JsonResponse
    {
        $balance = new Balance(
            $this->balanceService->getBalance(
                new Person($person),
                new PocketWallet($wallet)
            )
        );

        return response()->json($balance->response());
    }
}
