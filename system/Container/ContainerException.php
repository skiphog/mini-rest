<?php

namespace System\Container;

use InvalidArgumentException;

class ContainerException extends InvalidArgumentException
{
    protected $code = 500;
}
