<?php

namespace App\Exceptions;

use App\Domain\Exception\WalletDontHaveFundsException;
use App\Domain\Exception\WalletNotExistsException;
use App\Infrastructure\Http\Entity\StatusCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
                'transaction' => $request->all()
            ], StatusCode::NOT_FOUND->value);
        });

        $this->renderable(function (WalletDontHaveFundsException $e, Request $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'wallet' => $e->getWalletUuid(),
                'transaction' => $request->all()
            ], StatusCode::FORBIDDEN->value);
        });
    }
}
