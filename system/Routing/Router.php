<?php

/** @noinspection PhpIncludeInspection */

namespace System\Routing;

/**
 * Class Router
 *
 * @package System
 */
class Router
{
    /**
     * @var Route[]
     */
    protected $routes = [
        'GET'  => [],
        'POST' => [],
    ];

    /**
     * @var string|null
     */
    protected $prefix;

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * @param string $path
     *
     * @return Router
     */
    public static function load(string $path): Router
    {
        $route = new static();
        require $path;

        return $route;
    }

    /**
     * @param string $pattern
     * @param string $handler
     *
     * @return Route
     */
    public function get(string $pattern, string $handler): Route
    {
        return $this->setRoute('GET', $pattern, $handler);
    }

    /**
     * @param string $pattern
     * @param string $handler
     *
     * @return Route
     */
    public function post(string $pattern, string $handler): Route
    {
        return $this->setRoute('POST', $pattern, $handler);
    }

    /**
     * @param string $prefix
     * @param callable $callback
     * @param string|array $middleware
     */
    public function group(string $prefix, callable $callback, $middleware = []): void
    {
        $this->prefix = trim($prefix, '/');
        $this->middleware = (array)$middleware;
        $callback($this);
        $this->prefix = null;
        $this->middleware = [];
    }

    /**
     * @return array
     * @throws RouteException
     */
    public function match(): array
    {
        $uri = $this->uri();

        foreach ((array)$this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if (preg_match($this->resolvePattern($route->pattern()), $uri, $matches)) {
                return [$route, $matches];
            }
        }

        throw new RouteException("Роут {$_SERVER['REQUEST_METHOD']} [ {$uri} ] не зарегистрирован");
    }

    /**
     * @param string $method
     * @param string $pattern
     * @param string $handler
     *
     * @return Route
     */
    protected function setRoute(string $method, string $pattern, string $handler): Route
    {
        $pattern = trim($this->prefix . '/' . ltrim($pattern, '/'), '/');

        return $this->routes[$method][] = new Route($handler, $pattern, $this->middleware);
    }

    /**
     * @return string
     */
    protected function uri(): string
    {
        $uri = ltrim($_SERVER['REQUEST_URI'], '/');

        return (false !== $pos = strpos($uri, '?')) ? substr($uri, 0, $pos) : $uri;
    }

    /**
     * @param string $pattern
     *
     * @return string
     */
    protected function resolvePattern(string $pattern): string
    {
        $pattern = preg_replace_callback('#{([^}:]+):?([^}]*?)}#', static function ($matches) {
            return '(?P<' . $matches[1] . '>' . ($matches[2] ?: '.+') . ')';
        }, $pattern);

        return '#^' . $pattern . '$#';
    }
}
