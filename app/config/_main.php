<?php

//Main config file
Yii::setPathOfAlias('mobgen', realpath(dirname(__FILE__) . DS . '..' . DS . 'mobgen' . DS));

//define('BUNDLE_IN_APP', 'com.mobgen.flux.');

return array(
	'basePath' => dirname(__FILE__) . DS . '..',
	'runtimePath' => dirname(__FILE__) . DS . '..' . DS . '..' . DS . 'runtime',
	'preload' => array('log'),
	'onBeginRequest' => array('Controller', 'preloadModules'),
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.components.behaviors.*',
		'application.extensions.*',
		'application.extensions.getID3.*',
		'mobgen.notification.*',
	),
	'components' => array(
		'cache' => array(
//			'class' => 'CApcCache',
			'class' => 'CDummyCache',
		),
		'eventSystem' => array(
			'class' => 'EventSystem',
		),
		'db' => require(dirname(__FILE__) . '/db.php'),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
	),
    /* Solucion alternativa si no se da configurado imagick.so
    'image'=>array(
        'class'=>'application.extensions.image.CImageComponent',
        'driver'=>'ImageMagick', // GD or ImageMagick
        'params'=>array('directory'=>'/usr/local/bin'),// ImageMagick setup path, empty to autolocate on unix based systems
    ),
    */
	'params' => require(dirname(__FILE__) . '/params.php'),
);
