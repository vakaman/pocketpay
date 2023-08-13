<?php

namespace App\Models;

use App\Models\CastAttributes\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $casts = [
        'id' => 'string',
        'money' => Money::class
    ];

    public function person(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->using(PersonWallet::class);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)->using(WalletTransactions::class);
    }
}

