<?php

namespace System\Middleware;

use Closure;
use SplQueue;
use System\Http\Request;

/**
 * Class Pipline
 *
 * @package System\Middleware
 */
class Pipline
{
    /**
     * @var SplQueue
     */
    protected $queue;

    /**
     * Pipline constructor.
     */
    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    /**
     * @param string|Closure $middleware
     */
    public function pipe($middleware): void
    {
        $this->queue->enqueue($middleware);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function run(Request $request)
    {
        /** @var MiddlewareInterface $middleware */
        $middleware = $this->queue->dequeue();
        $middleware = $middleware instanceof Closure ? $middleware() : new $middleware();

        return $middleware->handle($request, function (Request $request) {
            return $this->run($request);
        });
    }
}
