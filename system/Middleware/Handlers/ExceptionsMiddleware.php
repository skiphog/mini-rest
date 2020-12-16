<?php

/** @noinspection PhpRedundantCatchClauseInspection */

namespace System\Middleware\Handlers;

use Throwable;
use System\Http\Request;
use System\Http\Exceptions\MultiException;
use System\Middleware\MiddlewareInterface;

abstract class ExceptionsMiddleware implements MiddlewareInterface
{
    /**
     * @param Request  $request
     * @param callable $next
     *
     * @return mixed
     */
    public function handle(Request $request, callable $next)
    {
        try {
            return $next($request);
        } catch (MultiException $e) {
            return $this->generateMultiError($request, $e);
        } catch (Throwable $e) {
            return $this->generateError($e);
        }
    }

    /**
     * @param Request        $request
     * @param MultiException $e
     *
     * @return mixed
     */
    abstract protected function generateMultiError(Request $request, MultiException $e);

    /**
     * @param Throwable $e
     *
     * @return mixed
     */
    abstract protected function generateError(Throwable $e);

    /**
     * @param Throwable $e
     *
     * @return int
     */
    protected function getStatusCode(Throwable $e): int
    {
        $code = $e->getCode();

        if ($code > 399 && $code < 600) {
            return $code;
        }

        return 500;
    }
}
