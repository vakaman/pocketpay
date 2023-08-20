<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonLegal extends Model
{
    use HasFactory;

    protected $table = 'person_legal';

    public $timestamps = false;

    protected $fillabble = [
        'name',
        'document',
        'email'
    ];
}
