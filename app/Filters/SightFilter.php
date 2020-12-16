<?php

namespace App\Filters;

class SightFilter extends Filter
{
    protected $filters = [
        'order',
    ];

    protected $fieldsOrder = [
        'id',
        'name',
        'distance',
        'rating'
    ];
}
