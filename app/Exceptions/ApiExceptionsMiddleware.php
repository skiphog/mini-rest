<?php

namespace App\Exceptions;

use Throwable;
use System\Http\Exceptions\NotFoundException;
use System\Middleware\Handlers\ApiExceptionsMiddleware as ExceptionsMiddleware;

class ApiExceptionsMiddleware extends ExceptionsMiddleware
{
    /**
     * @param Throwable $e
     *
     * @return mixed
     */
    protected function generateProduction(Throwable $e)
    {
        if ($e instanceof NotFoundException) {
            return json(['error' => $e->getMessage()], 404);
        }

        return parent::generateProduction($e);
    }
}
