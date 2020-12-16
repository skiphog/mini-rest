<?php

namespace System\Validate\Validation;

use System\Validate\Validator;
use System\Validate\Exceptions\ValidateException;

/**
 * Class ScalarValidate
 *
 * @package System\Validation
 */
abstract class ScalarValidate extends Validator
{

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validate($value)
    {
        $this->setParamValidate();

        if (!method_exists($this, $method = 'validate' . ucfirst(gettype($value)))) {
            throw new ValidateException(
                $this->getMessage("Тип Поля {$this->field} не определен")
            );
        }

        return $this->$method($value);
    }

    /**
     * @return void
     */
    abstract public function setParamValidate(): void;

    /**
     * @param $value
     *
     * @return mixed
     */
    abstract public function validateInteger($value);

    /**
     * @param $value
     *
     * @return mixed
     */
    abstract public function validateString($value);

    /**
     * @param $value
     *
     * @return mixed
     */
    abstract public function validateArray($value);
}
