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
        $code = $this->getStatusCode($e);

        if (isLocal()) {
            return $this->generateDebug($code, $e);
        }

        return $this->generateProduction($code);
    }

    /**
     * @param int $code
     * @param Throwable $e
     *
     * @return mixed
     */
    protected function generateDebug(int $code, Throwable $e)
    {
        return json([
            'except'  => get_class($e),
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
            'code'    => $e->getCode(),
        ], $code);
    }

    /**
     * @param int $code
     *
     * @return mixed
     */
    protected function generateProduction(int $code)
    {
        return json([
            'message' => 'Something went wrong',
            'code'    => $code,
        ], $code);
    }
}
