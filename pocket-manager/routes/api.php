<?php

use App\Infrastructure\Http\Controller\BalanceController;
use App\Infrastructure\Http\Controller\TransactionController;
use App\Infrastructure\Http\Controller\WalletController;
use Illuminate\Support\Facades\Route;

Route::get("/balance/{person}/{wallet}", [BalanceController::class, 'balance']);

Route::get("/transaction/{id}", [TransactionController::class, 'detail']);
Route::get("/transaction/history/{person}/{wallet}", [TransactionController::class, 'history']);
Route::post("/transaction", [TransactionController::class, 'transaction']);

Route::get("/wallet/person", [WalletController::class, 'all']);
Route::get("/wallet/person", [WalletController::class, 'main']);
Route::post("/wallet", [WalletController::class, 'create']);
Route::patch("/wallet/main", [WalletController::class, 'setMain']);
