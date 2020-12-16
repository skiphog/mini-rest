<?php

namespace System\Validate\Validation;

use System\Validate\Exceptions\RuleException;
use System\Validate\Exceptions\ValidateException;

use function count;
use function mb_strlen;
use function is_numeric;

/**
 * Class Max
 *
 * @package System\Validation
 */
class Max extends ScalarValidate
{
    /**
     * @var int
     */
    protected $max;

    public function setParamValidate(): void
    {
        if (null === $this->params || !is_numeric($this->params)) {
            throw new RuleException("Передан неверный параметр в max [{$this->params}]");
        }

        $this->max = (int)$this->params;
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validateInteger($value)
    {
        if ($value > $this->max) {
            throw new ValidateException($this->getMessage("Поле {$this->field} должно быть не более {$this->max}"));
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
        if (mb_strlen($value) > $this->max) {
            throw new ValidateException(
                $this->getMessage("Количество символов в поле {$this->field} должно быть не более {$this->max}")
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
        if (count($value) > $this->max) {
            throw new ValidateException(
                $this->getMessage("Количество элементов в массиве {$this->field} должно быть не более {$this->max}")
            );
        }

        return $value;
    }
}
