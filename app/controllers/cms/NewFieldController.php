<?php

class NewFieldController extends Controller
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
		$model=new NewField;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        $this->_process($model);

        $tables = $this->_getTablesDB($model);

		$this->render('create',array(
			'model'=>$model,
            'tables'=>$tables,
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

        $tables = $this->_getTablesDB($model);

		$this->render('update',array(
			'model'=>$model,
            'tables'=>$tables,
		));
	}

    private function _process($model) {

        //echo '<pre>';var_dump($_POST);echo '</pre>';die;
        if(isset($_POST['NewField']))
        {
            $model->attributes=$_POST['NewField'];
            if($model->save()){
                NewFieldProject::model()->deleteAllByAttributes(array('new_field_id'=>$model->id));
                //NewFielProjects
                if (isset($_POST['NewField']['newFieldProjects'])) {
                    $temp = $_POST['NewField']['newFieldProjects'];
                    foreach ($temp as $tt){
                        $aux = new newFieldProject();
                        $aux->new_field_id = $model->id;
                        $aux->project_id = $tt;
                        $aux->save();
                    }
                }
                $this->redirect(array('view','id'=>$model->id));
            }

        }
    }

        /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateFieldToProject()
    {
        $model=new NewField;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if(isset($_POST['NewField']))
        {
            $model->attributes=$_POST['NewField'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

        $tables = $this->_getTablesDB($model);

        $this->render('create',array(
            'model'=>$model,
            'tables'=>$tables,
        ));
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
		$dataProvider=new CActiveDataProvider('NewField');

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new NewField('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['NewField']))
			$model->attributes=$_GET['NewField'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return NewField the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=NewField::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param NewField $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='new-field-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


    private static function _getTablesDB()
    {
        $dao = Yii::app()->db;
        $sqlstr = 'SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = "mobgen_projects" AND auto_increment IS NOT NULL';
        $command = $dao->createCommand($sqlstr);

        //$command->bindParam(":status", $status, PDO::PARAM_INT);
        $dataReader = $command->query();
        foreach($dataReader as $row) {
            $rows[$row['table_name']]=$row['table_name'];
        }

        //var_dump($rows);die;
        return $rows;

    }
}
