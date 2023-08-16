<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PersonWallet extends Pivot
{
    protected $table = 'person_wallet';

    protected $casts = [
        'person_id' => 'string',
        'wallet_id' => 'string',
    ];
}
