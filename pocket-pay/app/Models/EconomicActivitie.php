<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EconomicActivitie extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillabble = [
        'id',
        'name',
        'code',
        'type_id'
    ];
}
