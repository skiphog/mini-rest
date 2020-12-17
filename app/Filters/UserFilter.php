<?php

namespace App\Filters;

class UserFilter extends Filter
{
    protected $filters = [
        'order',
    ];

    protected $fieldsOrder = [
        'id',
        'name'
    ];
}
