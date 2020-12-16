<?php

namespace System\Validate\Exceptions;

use BadFunctionCallException;

class RuleException extends BadFunctionCallException
{
    protected $code = 500;
}
