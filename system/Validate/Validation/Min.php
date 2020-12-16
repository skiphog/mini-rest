<?php

namespace System\Validate\Validation;

use System\Validate\Exceptions\RuleException;
use System\Validate\Exceptions\ValidateException;

use function count;
use function is_numeric;
use function mb_strlen;

/**
 * Class Min
 *
 * @package System\Validation
 */
class Min extends ScalarValidate
{
    /**
     * @var int
     */
    protected $min;

    public function setParamValidate(): void
    {
        if (null === $this->params || !is_numeric($this->params)) {
            throw new RuleException("Передан неверный параметр в min [{$this->params}]");
        }

        $this->min = (int)$this->params;
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validateInteger($value)
    {
        if ($value < $this->min) {
            throw new ValidateException($this->getMessage("Поле {$this->field} должно быть не менее {$this->min}"));
        }

        return $value;
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validateString($value)
    {
        if (mb_strlen($value) < $this->min) {
            throw new ValidateException(
                $this->getMessage("Количество символов в поле {$this->field} должно быть не менее {$this->min}")
            );
        }

        return $value;
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validateArray($value)
    {
        if (count($value) > $this->min) {
            throw new ValidateException(
                $this->getMessage("Количество элементов в массиве {$this->field} должно быть не менее {$this->min}")
            );
        }

        return $value;
    }
}
