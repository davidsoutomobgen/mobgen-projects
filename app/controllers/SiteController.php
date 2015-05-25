<?php

class SiteController extends Controller
{

	public function filters()
	{
		return array(
			'accessControl',
//			'https +login',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('login', 'error'),
				'users' => array('?'),
			),
			array('allow',
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		$this->pageTitle = Yii::app()->name;
	}

	public function actionIndex()
	{
//		$lastSent = SystemPush::model()->find()->last_sent;
		$sys = System::model()->find();
		$this->render('index', array('sys' => $sys)); //, 'lastSent' => $lastSent));
	}

	/* Other */

	public function actionError()
	{
		if (strpos(_app()->request->requestUri, '/api/') === false) {
			if ($error = Yii::app()->errorHandler->error) {
				$this->render('error', $error);
			}
		} else {
			$this->_sendResponse(400, 'Your request is invalid. Please refer to the API manual.');
		}
	}

	public function actionDebug()
	{
		$this->render('debug');
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm;
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			if ($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$this->render('login', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect('index');
	}

}