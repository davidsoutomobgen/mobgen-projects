<?php

/**
 * @author sfraembs
 *
 * @desc the console parse command with sdengine xml config implementation.
 *
 */
class ParserCommand extends CConsoleCommand {

	var $xmlconfig;

	protected function beforeAction($action, $params) {
		echo "::beforeAction()\n";
		$sdxmlcfg_classfile = "/data/www/sdengine_php53/html/include/cl_sdxmlconfig_v0514.php";
		include_once($sdxmlcfg_classfile);
		$this->xmlconfig = new SDXMLConfig("//MGAPICONFIG/ENVSETUPS/*");

		$this->xmlconfig->AddConfigLevel("DEFAULT_LINUX");

		// If we run from a home dir, lets asume this is a dev environment and add the user name to the config path:
		//  + DEV_USERNAME
		if (strncmp($_SERVER['argv'][0], "/home/", 6) == 0) {
			if (false !== ($npos = strpos($_SERVER['argv'][0], '/', 6))) {
				$envuser = substr($_SERVER['argv'][0], 6, $npos-6);
				$this->xmlconfig->AddConfigLevel("DEV_" . strtoupper($envuser));
			} else {
			}
		}

		$phpconfigcachedir = _app()->getRuntimePath()."/";
		$configfile        = _app()->getBasePath()."/../data/appconfig.xml";

		$this->xmlconfig->GetXMLConfigCustomSaved($configfile, $phpconfigcachedir, "appconfig.php");
		echo "the config path: ". $this->xmlconfig->env_actsetup["SDXMLCONFIG_SETUPLIST"] ."\n";

		// @SAS: This way we can make the config available in other parts of the yii project.
		Yii::app()->setParams( array('xmlconfig' => & $this->xmlconfig->env_actsetup));

		return parent::beforeAction($action, $params);
	}


	// Default action, in the yii code it looked like it would be called defaultAction()
	public function actionIndex() {
		echo "::actionIndex()\n";
        Yii::log("argv[0]=". $_SERVER['argv'][0]. "\n", CLogger::LEVEL_INFO, 'mobgen-script');
		return 0;	// This is returned by default (i think)
	}

    public function actionTest() {
	   	echo "::actionTest()\n";
    	Yii::log('actionTest...', CLogger::LEVEL_INFO, 'mobgen-script');
    	echo "did we log?\n";
    	echo '::getCommandPath(): '. _app()->getCommandPath() ."\n";
    	echo 'basePath: '. _app()->getBasePath() ."\n";
    	echo 'baseUrl: '. _app()->getBaseUrl() ."\n";
//    	echo 'request: '. _app()->getRequest() ."\n";
    	echo 'getRuntimePath(): '. _app()->getRuntimePath() ."\n";
    }

	public function actionTestPush() {
		echo "::actionTestPush()\n";

//		$pm = new MgPushManager();
		$pm = Yii::app()->mgpushmanager;
		$queueId = $pm->createQueue('com.mobgen.pushtest');
//		$queueId = $pm->createQueue('com.mobgen.shellinno', 'main');
//		$queueId = $pm->createQueue('com.mobgen.shellinno', 'background');
//		$queueId = $pm->createQueue('com.mobgen.shellinno');
		$tokenId = $pm->registerToken('com.mobgen.shellinno', '7141AF4B678461449DBEF98DB9FE55B845CD19BB3891FC5BE5E1FE55E88536AB');
//		$tokenId = $pm->registerToken('com.mobgen.shellinno', 'tst12345',
//							array('type'=>'android', 'device'=>'LG One', 'deviceos'=>'android') );
//		$tokenId = $pm->registerToken('com.mobgen.shellinno', 'APA91bGWikrEjd5moVXcv9NDY6bS60KV1mDGP-f1RlK0T699u-wUaEhsKFKom6Wu4HCBzS9b5JqaNGmFDlc0z09zSLEB7fSUa2rdx9LRW_OwopL0I1gif2RvdqINSjfFvGwVECpa_HCjY5Fr9nOZzgzrtBlDpvU3mg',
//							array('type'=>'android', 'device'=>'GT-I9000', 'deviceos'=>'Android-2.3.6') );
//		$tokenId = $pm->registerToken('com.mobgen.shellinno', 'APA91bESKRAmmFR_E0AQkiniobtXcBFvV6niTESRZYuVuvo-uLc8y5xKSF-yNZh5_2Pmen5TuyShNJuyMjozeIaPAeEnL4b9UZFm7lM9S8PnsWyfWM3tfDrtoeAq0D4-umtfxUrRIj1GViJ7MwA-kJ2VymNvDGBM5A',
//							array('type'=>'android', 'device'=>'GT-I9000', 'deviceos'=>'Android-2.3.6') );


		$messageId = $pm->getActiveMessage($queueId);
		if (!$messageId) {
			$messageId = $pm->createMessage('This is a yii MgPushManager test push message.');
			echo "Created new message with id $messageId\n";
		}

		$pm->pushToQueue($queueId, $tokenId, $messageId);
		$pm->prepareQueue($queueId);

//		$pm->processQueue($queueId);
//		$pm->processQueues('com.mobgen.shellinno', 'main');
//		$pm->processQueues('com.mobgen.shellinno');

//		echo "queueId: $queueId\n";
	}

	public function actionProcessQueues($bundleId, $tag=null) {
//		$pm = new MgPushManager();
		$pm = Yii::app()->mgpushmanager;
		$pm->processQueues($bundleId, $tag);
	}

}