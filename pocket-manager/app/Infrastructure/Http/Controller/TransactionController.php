<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Entity\Currency\Money;
use App\Domain\Entity\Financial\Transaction as FinancialTransaction;
use App\Domain\Entity\People\Person;
use App\Domain\ValueObject\Uuid;
use App\Http\Controllers\Controller;
use App\Infrastructure\Http\Entity\StatusCode;
use App\Infrastructure\Http\Entity\Transaction\TransactionRequest;
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
        $transaction = new TransactionHistory(
            $this->transactionService->history(
                new Person(new Uuid($person)),
                new Uuid($wallet)
            )
        );

        return response()->json($transaction->response());
    }

    public function transaction(TransactionRequest $transactionRequest)
    {
        $this->transactionService->createTransaction(
            new FinancialTransaction(
                from: new Uuid($transactionRequest->get('from_wallet')),
                to: new Uuid($transactionRequest->get('to_wallet')),
                value: new Money($transactionRequest->get('value')),
            )
        );

        return response()->noContent(StatusCode::CREATED->value);
    }
}
