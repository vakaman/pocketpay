<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonNatural extends Model
{
    use HasFactory;

    protected $table = 'person_natural';

    public $timestamps = false;

    protected $fillabble = [
        'name',
        'document',
        'email'
    ];
}
