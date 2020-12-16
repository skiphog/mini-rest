<?php

namespace System\Validate\Validation;

use System\Validate\Exceptions\RuleException;
use System\Validate\Exceptions\ValidateException;

use function count;
use function is_numeric;

/**
 * Class Between
 *
 * @package System\Validation
 */
class Between extends ScalarValidate
{
    /**
     * @var int
     */
    protected $min;

    /**
     * @var int
     */
    protected $max;

    public function setParamValidate(): void
    {
        if (null === $this->params) {
            throw new RuleException('Не передан параметр для валидации в between');
        }

        $params = explode(',', $this->params);

        if (2 !== count($params) || !is_numeric($params[0]) || !is_numeric($params[1]) || $params[0] > $params[1]) {
            throw new RuleException("Передан неверный параметр в between [{$this->params}]");
        }

        $this->min = (int)$params[0];
        $this->max = (int)$params[1];
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validateInteger($value)
    {
        if ($value < $this->min || $value > $this->max) {
            throw new ValidateException(
                $this->getMessage("Поле {$this->field} должно быть между {$this->min} и {$this->max}")
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
    public function validateString($value)
    {
        if (($length = mb_strlen($value)) < $this->min || $length > $this->max) {
            throw new ValidateException(
                $this->getMessage(
                    "Количество символов в поле {$this->field} должно быть между {$this->min} и {$this->max}"
                )
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
        if (($count = count($value)) < $this->min || $count > $this->max) {
            throw new ValidateException(
                $this->getMessage(
                    "Количество элементов в массиве {$this->field} должно быть между {$this->min} и {$this->max}"
                )
            );
        }

        return $value;
    }
}
