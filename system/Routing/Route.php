<?php

namespace System\Routing;

/**
 * Class Route
 *
 * @package System
 */
class Route
{
    /**
     * @var string
     */
    protected $handler;

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array;
     */
    protected $middleware = [];

    /**
     * Route constructor.
     *
     * @param string $handler
     * @param string $pattern
     * @param array $middleware
     */
    public function __construct(string $handler, string $pattern, array $middleware = [])
    {
        $this->handler = $handler;
        $this->pattern = $pattern;
        $this->middleware = $middleware;
    }

    /**
     * @param string $name
     *
     * @return Route
     */
    public function setName(string $name): Route
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string|array $middleware
     *
     * @return Route
     */
    public function middleware($middleware): Route
    {
        foreach ((array)$middleware as $item) {
            $this->middleware[] = $item;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function pattern(): string
    {
        return $this->pattern;
    }

    /**
     * @return array
     */
    public function getHandler(): array
    {
        return explode('@', $this->handler);
    }

    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }
}
