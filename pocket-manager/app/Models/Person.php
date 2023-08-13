<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public function wallets(): BelongsToMany
    {
        return $this->belongsToMany(Wallet::class)->using(PersonWallet::class);
    }
}
