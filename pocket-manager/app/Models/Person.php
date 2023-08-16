<?php

namespace App\Models;

use App\Models\CastAttributes\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id'
    ];

    public $timestamps = false;

    public function wallets(): BelongsToMany
    {
        return $this->belongsToMany(Wallet::class)->using(PersonWallet::class);
    }
}
