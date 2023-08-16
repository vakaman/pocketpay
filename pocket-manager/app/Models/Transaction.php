<?php

namespace App\Models;

use App\Domain\ValueObject\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    public $timestamps = true;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'status_id',
        'from',
        'to',
        'value',
        'created_at',
        'updated_at',
    ];

    public function wallets(): belongsToMany
    {
        return $this->belongsToMany(Wallet::class)->using(WalletTransactions::class);
    }

    public function statuses(): HasOne
    {
        return $this->hasOne(Statuses::class, 'id', 'status_id');
    }

    public function scopeId(Builder $query, Uuid $id): void
    {
        $query->where('id',  $id->value);
    }

    public function scopeAlreadyBeenDone(Builder $query, array $status): void
    {
        $query->whereIn('status_id', $status);
    }
}
