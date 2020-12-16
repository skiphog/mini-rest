<?php

/** @noinspection PhpIncludeInspection */

use System\Http\Request;
use System\Database\Connection;

return [

    /**
     * Инициализация Request
     */
    Request::class => static function () {
        return new Request();
    },

    /**
     * Инициализация подключения к MySql
     */
    Connection::class => static function () {
        return new Connection(config('mysql'));
    },
];
