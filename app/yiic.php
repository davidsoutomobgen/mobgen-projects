<?php
define('DS', DIRECTORY_SEPARATOR);
define('LOGPATH', realpath(dirname(__FILE__).DS.'..'.DS.'runtime').DS);

// change the following paths if necessary
$yiic=dirname(__FILE__).DS.'..'.DS.'..'.DS.'yii'.DS.'framework'.DS.'yiic.php';
$yiis=dirname(__FILE__).DS.'yii_shortcuts.php';
$config=dirname(__FILE__).DS.'config'.DS.'console.php';

require_once($yiis);
require_once($yiic);
