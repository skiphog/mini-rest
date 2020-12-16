<?php

namespace App\Validate;

use System\Validate\Exceptions\ValidateException;
use System\Validate\Interfaces\CustomValidatorInterface;

class EntityExists implements CustomValidatorInterface
{

    protected $param;


    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * @param $value
     *
     * @return mixed
     * @throws ValidateException
     */
    public function validate($value)
    {
        $sth = db()
            ->prepare(/** @lang */
                "select exists(select * from {$this->param} where id = :item)"
            );
        $sth->execute(['item' => $value]);

        if (false === (bool)$sth->fetchColumn()) {
            throw new ValidateException("{$this->param} с таким ID не существует");
        }

        return $value;
    }
}
