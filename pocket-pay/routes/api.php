<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('pocket-manager')->middleware('auth')->group(__DIR__ . '/pocket-manager.php');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
