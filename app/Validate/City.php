<?php

namespace App\Validate;

use System\Validate\Exceptions\ValidateException;
use System\Validate\Interfaces\CustomValidatorInterface;

class City implements CustomValidatorInterface
{
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
                "select exists(select * from cities where id = :item)"
            );
        $sth->execute(['item' => $value]);

        if (false === (bool)$sth->fetchColumn()) {
            throw new ValidateException('Города с таким ID не существует');
        }

        return $value;
    }
}
