<?php

namespace App\Filters;

class CityFilter extends Filter
{
    protected $filters = [
        'order',
    ];

    protected $fieldsOrder = [
        'id',
        'name'
    ];
}
