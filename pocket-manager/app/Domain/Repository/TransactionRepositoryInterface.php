<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;

/**
 * @see \App\Infrastructure\Repository\TransactionRepository
 */
interface TransactionRepositoryInterface
{
    public function detail(string $id): Transaction;

    public function history(string $wallet): TransactionHistory;
}
