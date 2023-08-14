<?php

namespace App\Service;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Exception\Transaction\TransactionFailException;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Infrastructure\Service\NotifyerService;
use App\Infrastructure\Service\TransactionAuthorizationService;
use App\Jobs\TransferFunds;

class TransactionService
{
    public function __construct(
        private WalletService $walletService,
        private TransactionRepositoryInterface $transactionRepository,
        private TransactionAuthorizationService $authorizationService,
        private NotifyerService $notifyerService
    ) {
    }

    public function detail(string $id): Transaction
    {
        $transaction = $this->transactionRepository->detail($id);

        return $transaction;
    }

    public function history(Person $person, Uuid $wallet): TransactionHistory
    {
        $this->walletService->belongsToPerson($wallet, $person);

        return $this->transactionRepository->history($wallet);
    }

    public function createTransaction(Transaction $transaction)
    {
        TransferFunds::dispatchIf(
            $this->canTransact($transaction),
            $transaction
        );
    }

    public function transact(Transaction $transaction): void
    {
        $this->commitTransaction($transaction);
    }

    private function commitTransaction(Transaction $transaction): void
    {
        if ($this->canTransact($transaction)) {

            throw_unless_transaction(
                fn () => $this->transactionRepository->transact($transaction) &&
                    $this->notifyerService->send($transaction),
                TransactionFailException::class,
                $transaction
            );
        }
    }

    private function canTransact(Transaction $transaction): bool
    {
        $this->walletExists($transaction);
        $this->haveFunds($transaction);

        return $this->authorizationService->canTransact($transaction);
    }

    private function walletExists(Transaction $transaction): bool
    {
        return $this->walletService->walletsExists(
            new Wallets([
                new Wallet(id: $transaction->from),
                new Wallet(id: $transaction->to),
            ])
        );
    }

    private function haveFunds(Transaction $transaction): bool
    {
        return $this->walletService->haveFunds(
            $transaction->from,
            $transaction->value
        );
    }
}
