<?php

namespace App\Service;

use App\Domain\Entity\Financial\Transaction;
use App\Domain\Entity\Financial\TransactionHistory;
use App\Domain\Entity\People\Person;
use App\Domain\Entity\Pocket\Wallet;
use App\Domain\Entity\Pocket\Wallets;
use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Exception\Transaction\PersonUnauthorizedToDoTransferException;
use App\Domain\Exception\Transaction\TransactionAlreadyBeenDoneException;
use App\Domain\Exception\Transaction\TransactionFailException;
use App\Domain\Repository\PersonServiceInterface;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\ValueObject\Uuid;
use App\Jobs\TransferFunds;
use App\Service\Interfaces\NotifyerServiceInterface;
use App\Service\Interfaces\TransactionAuthorizationServiceInterface;
use App\Service\Interfaces\TransactionServiceInterface;
use App\Service\Interfaces\WalletServiceInterface;

class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private WalletServiceInterface $walletService,
        private PersonServiceInterface $personService,
        private TransactionRepositoryInterface $transactionRepository,
        private TransactionAuthorizationServiceInterface $authorizationService,
        private NotifyerServiceInterface $notifyerService
    ) {
    }

    public function detail(string $id): Transaction
    {
        $transaction = $this->transactionRepository->detail($id);

        return $transaction;
    }

    public function history(Person $person, Uuid $wallet): TransactionHistory
    {
        $this->walletService->needExists(new Wallet($wallet));
        $this->personService->needExists($person);
        $this->walletService->belongsToPerson($wallet, $person);

        return $this->transactionRepository->history($wallet);
    }

    public function createTransaction(Transaction $transaction): void
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

    public function changeStatus(Transaction $transaction, TransactionStatusEnum $status): bool
    {
        return $this->transactionRepository->changeStatus($transaction, $status);
    }

    private function commitTransaction(Transaction $transaction): void
    {
        $this->canTransact($transaction);

        throw_unless_transaction(
            fn () =>
            $this->transactionRepository->transact($transaction) &&
                $transaction->setStatus(TransactionStatusEnum::SUCCESS) &&
                $this->transactionRepository->regiterTransactHistory($transaction) &&
                $this->notifyerService->send(
                    $this->notifyerService->notificationPackage($transaction)
                ),
            TransactionFailException::class,
            $transaction
        );
    }

    private function canTransact(Transaction $transaction): bool
    {
        $this->personCanTransferFunds($transaction);
        $this->transactionAlreadyBeenDone($transaction);
        $this->walletExists($transaction);
        $this->haveFunds($transaction);

        return $this->authorizationService->canTransact($transaction);
    }

    private function personCanTransferFunds(Transaction $transaction): bool
    {
        if (!$this->authorizationService->personCanTransferFunds($transaction)) {
            throw new PersonUnauthorizedToDoTransferException($transaction);
        }

        return true;
    }

    private function transactionAlreadyBeenDone(Transaction $transaction): bool
    {
        if ($this->transactionRepository->transactionAlreadyBeenDone($transaction)) {
            throw new TransactionAlreadyBeenDoneException($transaction);
        }

        return true;
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
