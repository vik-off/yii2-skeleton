<?php

$config = [
	'id' => 'vikoff-yii2-skeleton',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
		],
		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
					'logVars' => [],
				],
			],
		],
		'db' => [
			'class' => '\yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=test',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		],
	],
	'params' => [

		'adminEmail' => 'admin@example.com',
        'supportEmail' => 'support@example.com',

        'user.passwordResetTokenExpire' => 3600,
	],
];

return $config;