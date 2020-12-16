<?php

namespace App\Validate;

use System\Validate\Exceptions\ValidateException;
use System\Validate\Interfaces\CustomValidatorInterface;

class Test implements CustomValidatorInterface
{

    public function validate($value)
    {
        return $value;
    }
}
