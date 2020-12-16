<?php

namespace System\Middleware;

use RuntimeException;
use System\Http\Request;
use System\Routing\Route;
use System\Routing\Router;
use App\Middleware\Registrator;
use System\Routing\RouteException;

/**
 * Class RouteMiddleware
 *
 * @package System\Middleware
 */
class RouteMiddleware implements MiddlewareInterface
{
    /**
     * @param Request  $request
     * @param callable $next
     *
     * @return mixed
     * @throws RouteException
     */
    public function handle(Request $request, callable $next)
    {
        /** @var Route $route */
        [$route, $attributes] = Router::load(root_path('/routes.php'))->match();
        $request->setAttributes($attributes);

        $pipline = new Pipline();

        foreach (Registrator::$registry as $middleware) {
            $pipline->pipe($middleware);
        }

        foreach ($route->getMiddleware() as $name) {
            if (!isset(Registrator::$middleware[$name])) {
                throw new RuntimeException("Middleware [ {$name} ] не существует.");
            }

            $pipline->pipe(Registrator::$middleware[$name]);
        }

        $pipline->pipe(static function () use ($route) {
            return new ControllerMiddleware(... $route->getHandler());
        });

        return $pipline->run($request);
    }
}
