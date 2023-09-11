<?php

namespace App\Domain\Service;

use App\Domain\Entity\People\PersonAbstract;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Entity\Financial\TransactionHistory as FinancialTransactionHistory;

/**
 * @see \App\Infrastructure\Service\PocketManagerService
 */
interface PocketManagerServiceInterface
{
    public function list(PersonAbstract $person): Wallets;

    public function walletCreate(PersonAbstract $person): Wallet;

    public function walletDelete(Wallet $wallet): void;

    public function history(PersonAbstract $person): null|FinancialTransactionHistory;
}
