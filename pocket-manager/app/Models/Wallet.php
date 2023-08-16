<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'money',
        'main'
    ];

    public $timestamps = false;

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class)->using(PersonWallet::class);
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)->using(WalletTransactions::class);
    }
}
