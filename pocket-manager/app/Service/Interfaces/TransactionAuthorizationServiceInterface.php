<?php

namespace App\Service\Interfaces;

use App\Domain\Entity\Financial\Transaction;

/**
 * @see \App\Infrastructure\Service\TransactionAuthorizationService
 */
interface TransactionAuthorizationServiceInterface
{
    public function canTransact(Transaction $transaction): bool;

    public function personCanTransferFunds(Transaction $transaction): bool;
}
