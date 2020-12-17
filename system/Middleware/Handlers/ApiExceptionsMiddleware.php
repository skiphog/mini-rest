<?php

namespace System\Middleware\Handlers;

use Throwable;
use System\Http\Request;
use System\Http\Exceptions\MultiException;

use function get_class;

class ApiExceptionsMiddleware extends ExceptionsMiddleware
{
    /**
     * @param Request $request
     * @param MultiException $e
     *
     * @return mixed
     */
    protected function generateMultiError(Request $request, MultiException $e)
    {
        return json(['errors' => $e], 422);
    }

    /**
     * @param Throwable $e
     *
     * @return mixed
     */
    protected function generateError(Throwable $e)
    {
        if (isLocal()) {
            return $this->generateDebug($e);
        }

        return $this->generateProduction($e);
    }

    /**
     * @param Throwable $e
     *
     * @return mixed
     */
    protected function generateDebug(Throwable $e)
    {
        return json([
            'except'  => get_class($e),
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
            'code'    => $e->getCode(),
        ], $this->getStatusCode($e));
    }

    /**
     * @param Throwable $e
     *
     * @return mixed
     */
    protected function generateProduction(Throwable $e)
    {
        $code = $this->getStatusCode($e);

        return json([
            'message' => 'Something went wrong',
            'code'    => $code,
        ], $code);
    }
}
