<?php

class ModifierController extends Controller {

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'create', 'update', 'delete'),
				'users' => array('@'),
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		if (isset($_POST['Modifier'])) {
			$model->attributes = $_POST['Modifier'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('form', array(
			'model' => $model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex() {
		$model = new Modifier('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Modifier']))
			$model->attributes = $_GET['Modifier'];

		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Modifier the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = Modifier::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

}
