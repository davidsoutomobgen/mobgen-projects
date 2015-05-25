<?php
return CMap::mergeArray(require(dirname(__FILE__).'/main.php'), array(
    'name' => 'MobGen Console service',
    'components' => array(
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning, info',
					'maxFileSize' => '1024',
					'logFile' => 'mobgen-script.log',
					'categories' => 'mobgen-script',
					'logPath' => LOGPATH,
				),
			),
		),
    	'mgpushmanager' => array(
    		'class' => 'mobgen.notification.MgPushManager',
    		'profile' => 'production',
    		'certificates' => array(
    			'root' => dirname(__FILE__).DS.'..'.DS.'data'.DS.'entrust_2048_ca.pem',
    			'development' => realpath(dirname(__FILE__).DS.'..').DS.'data'.DS.'nibe-mobgen-development_2013-05-22.pem',
    			'production' => realpath(dirname(__FILE__).DS.'..').DS.'data'.DS.'nibe-mobgen-production_2013-05-22.pem',
    		),
    		'apns_hosts' => array(
				'development' => 'gateway.sandbox.push.apple.com',
				'production'  => 'gateway.push.apple.com',
			),
			'gcm_api_keys' => array(
				'development' => 'AIzaSyCBgprLZVyHq8AqhtbWwM5nHEPSx9NmRnk',
				'production' => 'AIzaSyCBgprLZVyHq8AqhtbWwM5nHEPSx9NmRnk',
			),
		),
    ),
/*	'params' => array(
			'console' => true,
			'xmlconfig' => '1',
	),
*/
));