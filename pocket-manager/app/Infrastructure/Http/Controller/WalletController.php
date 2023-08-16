<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\ValueObject\Uuid;
use App\Http\Controllers\Controller;
use App\Infrastructure\Http\Entity\StatusCode;
use App\Infrastructure\Http\Entity\Wallet\CreateWalletRequest;
use App\Infrastructure\Mapper\Api\Pocket\Wallet as PocketWallet;
use App\Infrastructure\Mapper\Api\Pocket\Wallets;
use App\Service\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    public function __construct(
        private WalletService $walletService
    ) {
    }

    public function create(CreateWalletRequest $createWalletRequest): Response
    {
        $this->walletService->create(
            new Person(id: new Uuid($createWalletRequest->get('person')))
        );

        return response()->noContent(StatusCode::CREATED->value);
    }

    public function all(string $person): JsonResponse
    {
        $allWallets = new Wallets(
            $this->walletService->all(
                new Person(id: new Uuid($person))
            )
        );

        return response()->json($allWallets->request());
    }

    public function main(string $person)
    {
        $wallet = new PocketWallet($this->walletService->main(
            new Person(id: new Uuid($person))
        ));

        return response()->json($wallet->request());
    }

    public function setMain($wallet): Response
    {
        $this->walletService->setMain(
            new Wallet(
                id: new Uuid($wallet),
                main: true
            )
        );

        return response()->noContent(StatusCode::OK->value);
    }
}
