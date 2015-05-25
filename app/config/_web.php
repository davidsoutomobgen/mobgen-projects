<?php
return CMap::mergeArray(require(dirname(__FILE__).'/main.php'), array(
	'name' => 'MOBGEN Projects',
//	'onBeginRequest' => array('Controller', 'preloadModules'),

	'import' => array(
		'application.extensions.PasswordHash',
		'mobgen.api.*',
	),
	'modules' => array(
		'gii' => array(
			'class' => 'system.gii.GiiModule',
			'password' => '123',
			'ipFilters' => array('127.0.0.1', '192.168.5.*', '::1'),
		),
	),
	'components' => array(
		'user' => array(
			'allowAutoLogin' => true,
		),
		'session' => array(
			'cookieParams' => array(
				'httpOnly' => true,
			),
		),
		'urlManager' => array(
			'urlFormat' => 'path',
			'rules' => array(
				array(
					'class' => 'application.components.ApiUrlRule',
					'connectionID' => 'db',
				),
				'<module:\w+>/<action:\w+>' 				 => '<module>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>' 	 => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' 			 => '<controller>/<action>',
				'cms/<controller:\w+>/<action:\w+>/<id:\d+>' => 'cms/<controller>/<action>',
				'cms/<controller:\w+>/<action:\w+>' 		 => 'cms/<controller>/<action>',
			),
			'showScriptName' => false,
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'resourceManager' => array(
			'class'	 => 'ResourceManager',
			'resources' => require(dirname(__FILE__) . DS . 'rest-resources.php')
		),
	),
));
