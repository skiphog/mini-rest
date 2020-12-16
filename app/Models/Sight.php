<?php

namespace App\Models;

use System\Database\Model;

class Sight extends Model
{
    protected $fillable = [
        'city_id',
        'name',
        'distance'
    ];

    public static $manyKey = 'city_id';

    public static $table = 'sights';

    public function setCityId($value): int
    {
        return $this->{'city_id'} = (int)$value;
    }

    public function setDistance($value): int
    {
        return $this->{'distance'} = (int)$value;
    }

    public function setRating($value): int
    {
        return $this->{'rating'} = (int)$value;
    }
}
