<?php

namespace App\Filters;

class CitySightFilter extends Filter
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
