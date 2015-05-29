<?php
define('DS', DIRECTORY_SEPARATOR);
define('LOGPATH', realpath(dirname(__FILE__).DS.'..'.DS.'runtime').DS);

// change the following paths if necessary
$yii=dirname(__FILE__).DS.'..'.DS.'..'.DS.'yii'.DS.'framework'.DS.'yiilite.php';
$config=dirname(__FILE__).DS.'..'.DS.'app'.DS.'config'.DS.'web.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_PROFILE') or define('YII_PROFILE',false);

require_once($yii);
require_once('..'.DS.'app'.DS.'yii_shortcuts.php');
Yii::createWebApplication($config)->run();

/*
error_reporting(E_ALL);
ini_set("display_startup_errors","1");
ini_set("display_errors","1");
*/