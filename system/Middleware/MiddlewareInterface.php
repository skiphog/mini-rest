<?php

namespace System\Middleware;

use System\Http\Request;

/**
 * Interface MiddlewareInterface
 *
 * @package System\Middleware
 */
interface MiddlewareInterface
{
    /**
     * @param Request  $request
     * @param callable $next
     *
     * @return mixed
     */
    public function handle(Request $request, callable $next);
}
