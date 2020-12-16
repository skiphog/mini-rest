<?php

namespace System;

use System\Http\Request;
use System\Middleware\Pipline;
use System\Container\Container;
use System\Middleware\RouteMiddleware;
use App\Exceptions\ApiExceptionsMiddleware;

class App extends Container
{
    /**
     * @var Pipline
     */
    protected $pipline;

    /**
     * App constructor.
     */
    protected function __construct()
    {
        $this->pipline = new Pipline();
    }

    /**
     * @param string $path
     *
     * @noinspection PhpIncludeInspection
     *
     * @return App
     */
    public static function create(string $path): App
    {
        static::set('root_path', $path);
        static::set('global_config', require "{$path}/config.php");

        return new static();
    }

    public function start(): void
    {
        $this->setRegistry();
        $this->setMiddleware();

        echo $this->pipline->run(app(Request::class));
    }

    /**
     * Регистрирует классы в Регистре
     */
    public function setRegistry(): void
    {
        foreach (require __DIR__ . '/registry.php' as $key => $value) {
            static::set($key, $value);
        }
    }

    /**
     * Регистрирует Middleware
     */
    protected function setMiddleware(): void
    {
        foreach ([ApiExceptionsMiddleware::class, RouteMiddleware::class] as $middleware) {
            $this->pipline->pipe($middleware);
        }
    }
}
