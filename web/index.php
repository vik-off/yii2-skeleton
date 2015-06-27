<?php

use yii\web\Application;

chdir(__DIR__);

// require config and define constants
$localConfig = require(__DIR__ . '/../config/local.php');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = yii\helpers\ArrayHelper::merge(
	require(__DIR__ . '/../config/common.php'),
	require(__DIR__ . '/../config/web.php'),
	$localConfig
);

$application = new Application($config);
$application->run();
