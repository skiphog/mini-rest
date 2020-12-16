<?php

namespace App\Models;

use System\Database\Model;

class User extends Model
{
    protected $fillable = [
        'name',
    ];

    public static $table = 'users';
}
