<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Entity\Financial\Transactions;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Models\Transaction as ModelsTransaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function detail(string $id): Transaction
    {
        $transaction = ModelsTransaction::findOrFail($id)->toArray();

        return Transaction::toEntity($transaction);
    }

    public function history(string $wallet): TransactionHistory
    {
        $transactions = ModelsTransaction::where('from', $wallet)
            ->get()
            ->toArray();

        return TransactionHistory::toEntity(
            new Transactions($transactions)
        );
    }
}
