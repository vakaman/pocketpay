<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'id',
        'type_id',
        'economic_activities_id'
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(UserPerson::class);
    }

    public function natural(): HasOne
    {
        return $this->hasOne(PersonNatural::class);
    }

    public function legal(): BelongsTo
    {
        return $this->belongsTo(PersonLegal::class);
    }
}
