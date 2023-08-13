<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public $timestamps = true;

    protected $casts = [
        'id' => 'string'
    ];

    public function wallets(): belongsToMany
    {
        return $this->belongsToMany(Wallet::class)->using(WalletTransactions::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class)->using(TransactionStatus::class);
    }
}
