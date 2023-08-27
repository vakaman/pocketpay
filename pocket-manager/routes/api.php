<?php

use App\Infrastructure\Http\Controller\BalanceController;
use App\Infrastructure\Http\Controller\TransactionController;
use App\Infrastructure\Http\Controller\WalletController;
use App\Infrastructure\Http\Entity\StatusCode;
use Illuminate\Support\Facades\Route;

Route::get("/balance/{person}/{wallet}", [BalanceController::class, 'balance']);

Route::get("/transaction/{id}", [TransactionController::class, 'detail']);
Route::get("/transaction/history/{person}/{wallet?}", [TransactionController::class, 'history']);
Route::post("/transaction", [TransactionController::class, 'transaction']);

Route::post("/wallet", [WalletController::class, 'create']);
Route::delete("/wallet/{wallet}", [WalletController::class, 'delete']);
Route::get("/wallet/main/person/{person}", [WalletController::class, 'main']);
Route::get("/wallet/all/person/{person}", [WalletController::class, 'all']);
Route::patch("/wallet/main/{wallet}", [WalletController::class, 'setMain']);
Route::patch("/wallet/funds/{wallet}/{money}", [WalletController::class, 'addFunds']);

################################################################################
########## MOCKS
Route::post("/can-transact", function () {
    return response()->json(['pode dale!']);
    // return response()->noContent(StatusCode::FORBIDDEN->value);
});

Route::get("/person/{person}", function () {
    return response()->json([
        'name' => 'Maicol Kaiser',
        'email' => 'eu@duvidei.com.br'
    ]);
    // return response()->noContent(StatusCode::NOT_FOUND->value);
});

Route::post("/can-do-transfer", function () {
    return response()->noContent(StatusCode::ACCEPTED->value);
    // return response()->noContent(StatusCode::FORBIDDEN);
});
