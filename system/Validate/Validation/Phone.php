<?php

namespace System\Validate\Validation;

use System\Validate\Validator;
use System\Validate\Exceptions\ValidateException;

use function count;

/**
 * Class Phone
 *
 * @package System\Validation
 */
class Phone extends Validator
{
    /**
     * @param $value
     *
     * @return string
     * @throws ValidateException
     */
    public function validate($value): string
    {
        $value = preg_replace('~\D~', '', $value);

        if (mb_strlen($value) !== 11 || !$this->passNumber($value)) {
            throw new ValidateException($this->getMessage("Поле {$this->field} должно быть телефонным номером"));
        }

        return $value;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    protected function passNumber($number): bool
    {
        return count(array_flip(str_split($number))) > 4;
    }
}
