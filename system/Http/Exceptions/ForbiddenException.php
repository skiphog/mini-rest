<?php

namespace System\Http\Exceptions;

use Exception;

/**
 * Class ForbiddenException
 *
 * @package System\Http\Exceptions
 */
class ForbiddenException extends Exception
{
    protected $code = 403;
}
