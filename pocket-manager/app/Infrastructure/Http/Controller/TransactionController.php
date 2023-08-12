<?php

namespace App\Infrastructure\Http\Controller;

use App\Http\Controllers\Controller;
use App\Service\TransactionService;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {
    }

}
