<?php

namespace System\Database;

use PDO;

class Connection extends PDO
{
    public function __construct(array $config)
    {
        parent::__construct(
            "mysql:dbname={$config['database']};host={$config['host']};charset={$config['charset']}",
            $config['username'],
            $config['password'],
            $config['options']
        );
    }
}
