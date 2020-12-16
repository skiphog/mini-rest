<?php

namespace System\Validate\Validation;

use System\Validate\Validator;
use System\Validate\Exceptions\RuleException;
use System\Validate\Exceptions\ValidateException;

use function is_string;

/**
 * Class Unique
 *
 * @package System\Validate\Validation
 */
class Unique extends Validator
{
    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validate($value)
    {
        if (null === $this->params || !is_string($this->params)) {
            throw new RuleException("Передан неверный параметр в unique [{$this->params}]");
        }

        $sth = db()->prepare(/** @lang */ "select exists(select * from {$this->params} where {$this->field} = :item)");
        $sth->execute(['item' => $value]);

        if ((bool)$sth->fetchColumn()) {
            throw new ValidateException($this->getMessage("{$this->field} уже существует"));
        }

        return $value;
    }
}
