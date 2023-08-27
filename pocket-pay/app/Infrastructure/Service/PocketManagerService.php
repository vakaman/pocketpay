<?php

namespace App\Infrastructure\Service;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\Financial\TransactionHistory as FinancialTransactionHistory;
use App\Domain\Entity\People\PersonAbstract;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Service\PocketManagerServiceInterface;
use App\Domain\ValueObject\Uuid;
use App\Exceptions\Pocket\CannotListWalletsException;
use App\Exceptions\Pocket\WalletCannotBeCreatedException;
use App\Exceptions\Pocket\WalletCannotBeDeletedException;
use App\Exceptions\Transaction\CantGetHistoryException;
use App\Infrastructure\Http\Api\Mapper\Financial\TransactionHistory;
use App\Infrastructure\Http\Api\Mapper\Pocket\CreateWallet;
use Illuminate\Support\Facades\Http;

class PocketManagerService implements PocketManagerServiceInterface
{
    public function list(PersonAbstract $person): Wallets
    {
        $response = Http::get(
            env('API_POCKET_MANAGER') . '/api/wallet/all/person/' . $person->id->value
        );

        if (!$response->ok()) {
            throw new CannotListWalletsException($person);
        }

        return new Wallets(
            $response->json()
        );
    }

    public function walletCreate(PersonAbstract $person): Wallet
    {
        $response = Http::post(
            env('API_POCKET_MANAGER') . '/api/wallet',
            (new CreateWallet($person))->toArray()
        );

        if (!$response->created()) {
            throw new WalletCannotBeCreatedException($person);
        }

        return new Wallet(
            id: new Uuid($response->json('id')),
            money: new Money($response->json('money')),
            main: $response->json('main'),
        );
    }

    public function walletDelete(Wallet $wallet): void
    {
        $response = Http::delete(
            env('API_POCKET_MANAGER') . '/api/wallet/' . $wallet->id->value
        );

        if (!$response->noContent()) {
            throw new WalletCannotBeDeletedException($wallet);
        }
    }

    public function history(PersonAbstract $person): FinancialTransactionHistory
    {
        $url = sprintf(
            '%s%s%s',
            env('API_POCKET_MANAGER'),
            '/api/transaction/history/',
            $person->id->value
        );

        $response = Http::get($url);

        $transactionHistory = TransactionHistory::fromArray($response->json());

        if (!$response->ok()) {
            throw new CantGetHistoryException($person);
        }

        return $transactionHistory;
    }
}
