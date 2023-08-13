<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transfer::class)->using(TransactionStatus::class);
    }
}
