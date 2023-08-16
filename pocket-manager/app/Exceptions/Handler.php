<?php

namespace App\Exceptions;

use App\Domain\Exception\People\PersonDoesNotExistsException;
use App\Domain\Exception\Transaction\PersonUnauthorizedToDoTransferException;
use App\Domain\Exception\Transaction\TransactionAlreadyBeenDoneException;
use App\Domain\Exception\Transaction\TransactionUnauthorizedException;
use App\Domain\Exception\WalletDontHaveFundsException;
use App\Domain\Exception\WalletNotBelongsToPersonException;
use App\Domain\Exception\WalletNotExistsException;
use App\Infrastructure\Http\Entity\StatusCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (\Throwable $e) {
            //
        });

        $this->renderable(function (WalletNotExistsException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'wallet' => $e->getWallet()->id->value,
                'request' => $request->all()
            ], StatusCode::NOT_FOUND->value);
        });

        $this->renderable(function (WalletDontHaveFundsException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'wallet' => $e->getWalletUuid(),
                'request' => $request->all()
            ], StatusCode::FORBIDDEN->value);
        });

        $this->renderable(function (WalletNotBelongsToPersonException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'wallet' => $e->getWalletUuid(),
                'person' => $e->getPersonUuid(),
                'request' => $request->all()
            ], StatusCode::FORBIDDEN->value);
        });

        $this->renderable(function (PersonDoesNotExistsException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'person' => $e->getPerson()->id->value,
                'request' => $request->all()
            ], StatusCode::NOT_FOUND->value);
        });

        $this->renderable(function (TransactionAlreadyBeenDoneException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'transaction' => $e->getTransaction()->id->value
            ], StatusCode::FORBIDDEN->value);
        });

        $this->renderable(function (PersonUnauthorizedToDoTransferException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'request' => $request->all()
            ], StatusCode::FORBIDDEN->value);
        });

        $this->renderable(function (TransactionUnauthorizedException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'request' => $request->all()
            ], StatusCode::FORBIDDEN->value);
        });

        $this->renderable(function (HttpClientException $e, Request $request) {
            return response()->json([
                'error' => "The transaction could not be completed, please try again later.",
            ], StatusCode::SERVER_UNAVAILABLE->value);
        });
    }
}
