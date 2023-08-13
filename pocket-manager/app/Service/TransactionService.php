<?php

namespace App\Service;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Repository\TransactionRepositoryInterface;

class TransactionService
{
    public function __construct(
        private WalletService $walletService,
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function detail(string $id): Transaction
    {
        $transaction = $this->transactionRepository->detail($id);

        return $transaction;
    }

    public function history(string $person, string $wallet): TransactionHistory
    {
        $this->walletService->belongsToPerson($wallet, $person);

        return $this->transactionRepository->history($wallet);
    }
}
