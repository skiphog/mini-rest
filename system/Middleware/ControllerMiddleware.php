<?php

namespace System\Middleware;

use Throwable;
use System\Http\Request;
use System\Foundation\Controller;

/**
 * Class ControllerMiddleware
 *
 * @package System\Middleware
 */
class ControllerMiddleware implements MiddlewareInterface
{
    /**
     * @var Controller
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * ControllerMiddleware constructor.
     *
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $controller, string $action)
    {
        $controller = 'App\\Controllers\\' . $controller;
        $this->controller = new $controller();
        $this->action = $action;
    }

    /**
     * @param Request $request
     * @param callable $next
     *
     * @return mixed
     * @throws Throwable
     */
    public function handle(Request $request, callable $next)
    {
        return $this->controller->callAction($this->action, $request);
    }
}
