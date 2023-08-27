<?php

namespace App\Service\Interfaces;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Entity\People\Person;
use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\ValueObject\Uuid;

/**
 * @see \App\Service\TransactionService
 */
interface TransactionServiceInterface
{
    public function detail(string $id): Transaction;

    public function history(Person $person, Uuid $wallet = null): TransactionHistory;

    public function createTransaction(Transaction $transaction): void;

    public function transact(Transaction $transaction): void;

    public function changeStatus(Transaction $transaction, TransactionStatusEnum $status): bool;
}
