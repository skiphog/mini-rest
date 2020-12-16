<?php

namespace App\Models;

use System\Database\Model;

/**
 * Class City
 *
 * @package App\Models
 */
class City extends Model
{
    protected $fillable = ['name'];

    public static $table = 'cities';

}
