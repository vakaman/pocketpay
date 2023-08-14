<?php

namespace App\Jobs;

use App\Domain\Entity\Financial\Transaction;
use App\Service\TransactionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferFunds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $maxExceptions = 5;

    public $timeout = 60;

    public function __construct(
        private Transaction $transaction,
        private TransactionService $transactionService
    ) {
    }

    public function handle(): void
    {
        $this->transactionService->transact($this->transaction);
    }
}
