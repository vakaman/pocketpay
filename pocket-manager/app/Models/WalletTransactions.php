<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class WalletTransactions extends Pivot
{
    protected $table = 'wallet_transaction';
}

