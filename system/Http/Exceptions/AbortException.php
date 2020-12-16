<?php

namespace System\Http\Exceptions;

use Exception;

/**
 * Class AbortException
 *
 * @package System\Http\Exceptions
 */
class AbortException extends Exception
{
    protected $code = 404;
}
