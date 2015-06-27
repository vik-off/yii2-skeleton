<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

return [
    'components' => [

        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => '',
        ],
    ],
];