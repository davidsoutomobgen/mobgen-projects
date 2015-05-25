<?php

class MobgennerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Mobgenner;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        $this->_process($model);
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        $this->_process($model);
        $user = '';
        if ($model->user != 0)
            $user = Webuser::model()->findByPk($model->user);


        $this->render('update',array(
			'model'=>$model,
            'user'=>$user,
		));
	}


    private function _process($model) {

        if (isset($_POST['Mobgenner'])) {
            $model->attributes = $_POST['Mobgenner'];
            $model->mobgenner = CUploadedFile::getInstance($model, 'image');

            if ($model->mobgenner){
                $model->image = uniqid(mt_rand()).'_'.str_replace(' ', '_', $model->mobgenner->name);
                //$filename = substr($model->image, 0, -4);
                //$extension = substr($model->imge, -3);

            }
            if ($model->save()) {
                if ($model->mobgenner) {
                    $model->mobgenner->saveAs($model->mobgennerPath . $model->image);
                    //$this->_processType($filename, $model->typePath, $extension);
                }


                //
                WebuserProject::model()->deleteAllByAttributes(array('webuser_id'=>$model->id));
                if (isset($_POST['Mobgenner']['role'])) {
                    $temp = $_POST['Mobgenner']['role'];

                    //var_dump($model->user);die;
                    Utils::registerCssFile('form');

                    $user = Webuser::model()->findByPk($model->user);
                    if (empty($user))
                        $user = new Webuser;

                    $_POST['Webuser']['username'] = $model->email;
                    $_POST['Webuser']['password'] = 'mobgen';
                    $_POST['Webuser']['active'] = 1;
                    $user->attributes = $_POST['Webuser'];
                    $user->last_login = date(DATE_ISO8601);

                    if (in_array(9, $_POST['Mobgenner']['role']))
                        $user->role = 9;
                    else
                        $user->role = 0;

                    //echo '<pre>';print_r($_POST);echo '</pre>';//die;
                    //echo '<pre>';print_r($user);echo '</pre>';die;

                    //var_dump($_POST);

                    $user->save();
                    //print_r($user->getErrors());
                    //die;
                    if (!in_array(9, $_POST['Mobgenner']['role'])){
                        foreach ($temp as $k=>$tt){
                            $aux = new WebuserProject();
                            $aux->webuser_id = $model->id;
                            foreach ($_POST['Mobgenner']['user_type_'.$k] as $project_id){
                                $aux->project_id = $project_id;
                                $aux->role_id = $tt;
                                $aux->save();
                            }
                        }
                    }
                }
                ///

                $this->redirect(array('/cms/mobgenner/view/'.$model->id));
            }
        }
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model = new Mobgenner('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Mobgenner']))
            $model->attributes = $_GET['Mobgenner'];

        //var_dump($model);
        $this->render('index', array(
            'model' => $model,
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Mobgenner('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Mobgenner']))
			$model->attributes=$_GET['Mobgenner'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Mobgenner the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Mobgenner::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Mobgenner $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mobgenner-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
