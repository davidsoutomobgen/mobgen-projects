<?php

/**
 *
 * The Base controller for the Mobgen's API
 *
 * @author David Souto <david.souto@mobgen.com>
 */
class MGApiController extends CController {

	protected $apiRequest;
	protected $apiResponse;
	protected $customHeader = false;

	/**
	 * Defines a specific errorHandler for the api context
	 */
	//TODO define a custom error handler for the api
	public function init() {
		parent::init();
		Yii::app()->errorHandler->errorAction = "api/error";

		$apiRequest = new MGJSONApiRequest;
		$this->apiRequest = $apiRequest;

		$apiResponse = new MGJSONApiResponse;
		$apiResponse->setProtocol(new MGApiResponseProtocolHttp11);
		$apiResponse->customHeader = $this->customHeader;
		$this->apiResponse = $apiResponse;
	}

	/**
	 * Before action used to log every request
	 * */
	protected function beforeAction($action) {
		//Request from: USER_HOST_ADDRESS [USER_AGENT], Request was: URL
		Yii::log('Request was: ' . _app()->request->url, CLogger::LEVEL_INFO, 'api');
		Yii::log('Request from: ' . _app()->request->userHostAddress . '[' . _app()->request->userAgent . ']', CLogger::LEVEL_INFO, 'api');

		return parent::beforeAction($action);
	}

	/**
	 * This function is used to manage the response
	 * TODO introduce details in the response
	 */
	protected function respond($status, $message, $logDetails = null) {
		$this->apiResponse->sendResponse($status, $message);

		Yii::log('Response Status: ' . $status, CLogger::LEVEL_INFO, 'api');

		$logMessage = "";
		if (YII_DEBUG && isset($logDetails)) {
			if (is_object($logDetails))
				$logDetails = Utils::toArray($logDetails);

			if (is_array($logDetails)) {
				foreach ($logDetails as $msg => $err) {
					if (is_array($err)) {
						$logMessage .= ' Details: ';
						foreach ($err as $errDetail) {
							$logMessage .= $errDetail . " - ";
						}
					} else {
						$logMessage .= ' ' . ucfirst($msg) . ': ' . $err . "\r\n";
					}
				}
			} else {
				$logMessage = $logDetails;
			}
		}

		Yii::trace('Response Details: ' . $logMessage, 'api');
		_app()->end();
	}

	/**
	 * Get data submited by the client
	 * TODO crosscutting
	 */
	protected function data() {
		if ($this->apiRequest->getData() == null) {
			if (!$this->apiRequest->setData(Yii::app()->getRequest()->getRawBody())) {
				$errorMessage = new MGApiMessage("POST data is not valid", $this->apiRequest->getErrors());
				$this->respond(400, $errorMessage, $this->apiRequest->getErrors());
			}
		}

		return $this->apiRequest->getData();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		Yii::log('API Error: ' . Yii::app()->errorHandler->error, CLogger::LEVEL_ERROR, 'api');
		$this->respond(500, "Some problems occurred in the API", "Some problems occurred in the API");
	}

}
