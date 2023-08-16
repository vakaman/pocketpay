<?php

namespace App\Jobs;

use App\Domain\Entity\Financial\Transaction;
use App\Service\Interfaces\TransactionServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferFunds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $maxExceptions = 5;

    public $timeout = 60;

    public function __construct(
        private Transaction $transaction
    ) {
    }

    public function handle(TransactionServiceInterface $transactionService): void
    {
        $transactionService->transact($this->transaction);
    }
}
