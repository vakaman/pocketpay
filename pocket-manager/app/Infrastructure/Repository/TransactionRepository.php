<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Entity\Financial\Transactions;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Models\Transaction as ModelsTransaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function detail(string $id): Transaction
    {
        $transaction = ModelsTransaction::findOrFail($id)->toArray();

        return Transaction::toEntity($transaction);
    }

    public function history(Uuid $wallet): TransactionHistory
    {
        $transactions = ModelsTransaction::where('from', $wallet->value)
            ->get()
            ->toArray();

        return TransactionHistory::toEntity(
            new Transactions($transactions)
        );
    }

    public function transact(Transaction $wallet): bool
    {
        return true;
    }
}
