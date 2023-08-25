<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\ValueObject\Uuid;
use App\Http\Controllers\Controller;
use App\Infrastructure\Http\Entity\StatusCode;
use App\Infrastructure\Http\Entity\Wallet\CreateWalletRequest;
use App\Infrastructure\Mapper\Api\Pocket\Wallet as PocketWallet;
use App\Infrastructure\Mapper\Api\Pocket\Wallets;
use App\Service\Interfaces\WalletServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    public function __construct(
        private WalletServiceInterface $walletService
    ) {
    }

    public function create(CreateWalletRequest $createWalletRequest): JsonResponse
    {
        $wallet = new PocketWallet($this->walletService->create(
            new Person(id: new Uuid($createWalletRequest->get('person')))
        ));

        return response()->json($wallet->toArray(), StatusCode::CREATED->value);
    }

    public function delete(string $id): Response
    {
        $this->walletService->delete(new Wallet(id: $id));

        return response()->noContent(StatusCode::NO_CONTENT->value);
    }

    public function all(string $person): JsonResponse
    {
        $allWallets = new Wallets(
            $this->walletService->all(
                new Person(id: new Uuid($person))
            )
        );

        return response()->json($allWallets->toArray());
    }

    public function main(string $person): JsonResponse
    {
        $wallet = new PocketWallet($this->walletService->main(
            new Person(id: new Uuid($person))
        ));

        return response()->json($wallet->toArray());
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

    public function addFunds(string $wallet, int $money): Response
    {
        $this->walletService->addFunds(new Wallet(new Uuid($wallet)), new Money($money));

        return response()->noContent(StatusCode::OK->value);
    }
}
