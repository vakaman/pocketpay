<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonLegal extends Model
{
    use HasFactory;

    protected $primaryKey = 'person_id';

    protected $table = 'person_legal';

    protected $keyType = 'string';

    public $timestamps = false;

    protected $casts = [
        'person_id' => 'string'
    ];

    protected $fillable = [
        'person_id',
        'name',
        'document',
        'email'
    ];
}
