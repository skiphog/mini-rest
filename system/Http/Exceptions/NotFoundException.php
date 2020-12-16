<?php

namespace System\Http\Exceptions;

use Exception;

/**
 * Class NotFoundException
 *
 * @package System\Http\Exceptions
 */
class NotFoundException extends Exception
{
    protected $code = 404;
}
