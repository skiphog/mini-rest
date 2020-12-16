<?php

namespace App\Models;

use System\Database\Model;

class Travel extends Model
{
    protected $fillable = [
        'user_id',
        'sight_id',
        'rate',
    ];

    public static $table = 'travelings';
}
