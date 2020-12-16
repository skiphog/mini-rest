<?php

namespace App\Middleware;

/**
 * Class Registrator
 *
 * @package App\Middleware
 */
class Registrator
{
    /**
     * @var array
     */
    public static $registry = [
        CorsMiddleware::class
    ];

    /**
     * @var array
     */
    public static $middleware = [

    ];
}
