<?php
define('DS', DIRECTORY_SEPARATOR);
define('LOGPATH', realpath(dirname(__FILE__).DS.'..'.DS.'runtime').DS);

/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).DS.'..'.DS.'..'.DS.'yii'.DS.'framework'.DS.'yii.php';
$config=dirname(__FILE__).DS.'..'.DS.'app'.DS.'config'.DS.'test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
