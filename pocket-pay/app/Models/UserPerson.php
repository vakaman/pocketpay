<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserPerson extends Pivot
{
    protected $table = 'users_person';

    public $timestamps = false;
}
