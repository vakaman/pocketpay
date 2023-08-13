<?php

namespace App\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use App\Infrastructure\Mapper\Api\Transaction;
use App\Infrastructure\Mapper\Api\TransactionHistory;
use App\Service\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {
    }

    public function detail(string $id): JsonResponse
    {
        $transaction = new Transaction($this->transactionService->detail($id));

        return response()->json($transaction->response());
    }

    public function history(string $person, string $wallet): JsonResponse
    {
        $transaction = new TransactionHistory($this->transactionService->history($person, $wallet));

        return response()->json($transaction->response());
    }
}
