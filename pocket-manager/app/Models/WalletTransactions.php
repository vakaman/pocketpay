<?php

namespace App\Models;

use App\Models\CastAttributes\Uuid;
use Illuminate\Database\Eloquent\Relations\Pivot;

class WalletTransactions extends Pivot
{
    protected $table = 'wallet_transaction';

    protected $casts = [
        'wallet_id' => Uuid::class,
        'transaction_id' => Uuid::class
    ];
}
