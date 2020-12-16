<?php

namespace System\Validate\Validation;

use System\Validate\Validator;
use System\Validate\Exceptions\ValidateException;

/**
 * Class Integer
 *
 * @package System\Validation
 */
class Integer extends Validator
{
    /**
     * @param $value
     *
     * @return int
     * @throws ValidateException
     */
    public function validate($value): int
    {
        if (false === $value = filter_var($value, FILTER_VALIDATE_INT)) {
            throw new ValidateException($this->getMessage("Поле {$this->field} должно быть целым числом"));
        }

        return $value;
    }
}
