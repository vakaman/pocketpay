<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $primaryKey = 'id';

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
}
