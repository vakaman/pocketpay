<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Entity\Financial\Transactions;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Models\Transaction as ModelsTransaction;

class TransactionRepository implements TransactionRepositoryInterface
{

    public function __construct(
        private WalletRepositoryInterface $walletRepository
    ) {
    }

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

    public function transact(Transaction $transaction): bool
    {
        if (
            $this->walletRepository->subtractfunds(
                new Wallet($transaction->from),
                $transaction->value
            ) &&
            $this->walletRepository->addFunds(
                new Wallet($transaction->to),
                $transaction->value
            )
        ) {
            return true;
        }
        return false;
    }
}
