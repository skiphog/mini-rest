<?php

namespace App\Models;

use System\Database\Model;
use System\Database\ActiveRecord;

class User extends Model
{
    use ActiveRecord;

    protected static $table = 'users';
}
