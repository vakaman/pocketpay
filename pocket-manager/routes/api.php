<?php

use App\Infrastructure\Http\Controller\BalanceController;
use App\Infrastructure\Http\Controller\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get("/balance/{person}/{pocket}", [BalanceController::class, 'balance']);

Route::get("/transaction/{id}", [TransactionController::class, 'detail']);
Route::get("/transaction/history/{person}/{pocket}", [TransactionController::class, 'history']);
Route::post("/transaction", [TransactionController::class, 'transaction']);

Route::post("/pocket", [PocketController::class, 'create']);
Route::patch("/pocket", [PocketController::class, 'setMain']);

