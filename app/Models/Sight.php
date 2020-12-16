<?php

namespace App\Models;

use System\Database\Model;

class Sight extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'city_id',
        'name',
        'distance'
    ];

    /**
     * @var string
     */
    public static $manyKey = 'city_id';

    /**
     * @var string
     */
    public static $manyKeyThrow = 'user_id';

    /**
     * @var string
     */
    public static $table = 'sights';

    public function setCityId($value): int
    {
        return $this->{'city_id'} = (int)$value;
    }

    public function setDistance($value): int
    {
        return $this->{'distance'} = (int)$value;
    }

    public function setRating($value): ?int
    {
        return $this->{'rating'} = empty($value) ? null : (int)$value;
    }
}
