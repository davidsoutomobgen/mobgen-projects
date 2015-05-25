<?php

return CMap::mergeArray(
	require(dirname(__FILE__) . '/main.php'), array(
		'components' => array(
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager',
			),
			'db'         => require(dirname(__FILE__) . DS . 'dbTest.php'),
			'urlManager' => array(
				'showScriptName' => true,
			),
		),
	)
);
