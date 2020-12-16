<?php

namespace System\Validate\Validation;

use System\Validate\Validator;
use System\Validate\Exceptions\ValidateException;

/**
 * Class Email
 *
 * @package System\Validation
 */
class Email extends Validator
{
    /**
     * @param $value
     *
     * @return string
     * @throws ValidateException
     */
    public function validate($value): string
    {
        if (false === $value = filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ValidateException(
                $this->getMessage("Поле {$this->field} должно быть действительным электронным адресом")
            );
        }

        return strtolower(trim($value));
    }
}
