<?php

namespace System\Validate\Validation;

use System\Validate\Validator;
use System\Validate\Exceptions\ValidateException;

/**
 * Class Email
 *
 * @package System\Validation
 */
class Str extends Validator
{
    /**
     * @param $value
     *
     * @return string
     * @throws ValidateException
     */
    public function validate($value): string
    {
        if (!is_string($value)) {
            throw new ValidateException(
                $this->getMessage("Поле {$this->field} должно быть строкой")
            );
        }

        return $value;
    }
}
