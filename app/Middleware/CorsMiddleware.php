<?php

namespace App\Middleware;

use System\Http\Request;
use System\Http\Response;
use System\Middleware\MiddlewareInterface;

/**
 * Class AuthMiddleware
 *
 * @package App\Middleware
 */
class CorsMiddleware implements MiddlewareInterface
{
    /**
     * @var array
     */
    protected static $headers = [

        'GET'  => [
            'Access-Control-Allow-Origin' => '*',
        ],

        'POST' => [
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => 'POST',
            'Access-Control-Max-Age'       => '3600',
            'Access-Control-Allow-Headers' => 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'
        ]
    ];

    /**
     * @param Request  $request
     * @param callable $next
     *
     * @return Response
     */
    public function handle(Request $request, callable $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        return $response->withHeaders(static::$headers[$request->type()]);
    }
}
