<?php

use App\Http\Controllers\Pocket\WalletController;
use Illuminate\Support\Facades\Route;

Route::post('/wallet/create', [WalletController::class, 'create'])
    ->name('pocket-manager.wallet.create');

Route::post('/wallet/delete', [WalletController::class, 'delete'])
    ->name('pocket-manager.wallet.delete');
