<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TransactionStatus extends Pivot
{
    protected $table = 'transaction_status';

}
