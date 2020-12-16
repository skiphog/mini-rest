<?php

return [
    /**
     * Окружение:  local | production
     */
    'env' => 'local',

    /**
     * Подключение к MySQL
     */

    'mysql' => [
        'host'     => '127.0.0.1',
        'database' => 'rest',
        'username' => 'root',
        'password' => 'root',
        'charset'  => 'utf8mb4',
        'options'  => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            //PDO::ATTR_EMULATE_PREPARES  => false,
            //PDO::ATTR_STRINGIFY_FETCHES => false
        ],
    ],
];
