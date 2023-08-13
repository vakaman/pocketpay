<?php

namespace App\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use App\Service\WalletService;

class WalletController extends Controller
{
    public function __construct(
        private WalletService $walletService
    ) {
    }

}
