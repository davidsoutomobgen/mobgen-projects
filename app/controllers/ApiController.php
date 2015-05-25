<?php

/**
 *
 * The controller for the REST API
 */
class ApiController extends MGRestController {

	protected $user = false;

	/**
	 * Create a custom header for all responses to the client
	 */
	protected function beforeAction($action) {
		$this->skipREST = true;
		if (isset($_GET['isRest'])) {
			$this->skipREST = !$_GET['isRest'];
		}

		return parent::beforeAction($action);
	}

	/**
	 * Show the API documentation
	 */
	public function actionIndex() {
		die("Nothing to do here.");
	}

	public function actionBio() {
		if (!$model = Content::model()->find())
			$this->respond(404, "Not Found");

		$this->respond(200, array("response" => $model->biography));
	}

	public function actionSearchTag() {
		if (!$model = Content::model()->find())
			$this->respond(404, "Not Found");

		$this->respond(200, array("response" => $model->tag));
	}

	public function actionDebug() {
		$this->render('debug');
	}

	//__________________END CUSTOMIZED ACTIONS__________________

	/** Customized response just to remove the null values
	 *
	 * @param      $status
	 * @param      $body
	 * @param null $logMessage
	 */
	protected function respond($status, $body, $logMessage = null) {
		parent::respond($status, $body, $logMessage);
		_app()->end();
	}

}