<?php

namespace System\Validate\Validation;

use System\Validate\Validator;
use System\Validate\Exceptions\ValidateException;

/**
 * Class Required
 *
 * @package System\Validation
 */
class Required extends Validator
{
    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function process($value)
    {
        return $this->validate($value);
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validate($value)
    {
        if (null === $value || '' === $value) {
            throw new ValidateException($this->getMessage("Поле {$this->field} обязательно для заполнения"));
        }

        return $value;
    }
}
