<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\ValueObject\Uuid;

/**
 * @see \App\Infrastructure\Repository\TransactionRepository
 */
interface TransactionRepositoryInterface
{
    public function detail(string $id): Transaction;

    public function history(Uuid $wallet): TransactionHistory;

    public function transact(Transaction $wallet): bool;

    public function regiterTransactHistory(Transaction $transaction): Transaction;

    public function transactionAlreadyBeenDone(Transaction $transaction): bool;
}
