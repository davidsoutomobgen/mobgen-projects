<?php

class TypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

    //public $layout='//layouts/column2';

    public $breadcrumbs = array();
    public $menu = array();

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
		$model=new Type;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        /*
		if(isset($_POST['Type']))
		{
			$model->attributes=$_POST['Type'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
        */

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
        /*
		if(isset($_POST['Type']))
		{
			$model->attributes=$_POST['Type'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
        */
        $this->_process($model);

		$this->render('update',array(
			'model'=>$model,
		));
	}


    private function _process($model) {

        if (isset($_POST['Type'])) {
            //var_dump($_POST);
            $model->attributes = $_POST['Type'];
            $model->type = CUploadedFile::getInstance($model, 'logo');

            if ($model->type){
                $model->logo = uniqid(mt_rand()).'_'.str_replace(' ', '_', $model->type->name);
                //$extension = end(explode(".", $model->logo)); //substr($model->logo, -3);
                //$filename = basename($path, ".".extension);
                //echo  $filename.'.'.$extension; die;
            }
            if ($model->save()) {
                if ($model->type) {
                    $model->type->saveAs($model->typePath . $model->logo);
                    //$this->_processType($filename, $model->typePath, $extension);
                }
                $this->redirect(array('index'));
            }
        }
    }

    /**
     * Creates three preview particles from an particle or document
     *
     * @param string $particle
     * @param string $filename
     */
    /*
    private function _processType($filename, $path, $format='jpg') {
        $type=new Imagick($path.$filename.'.'.$format);
        $type->setImageFormat($format);

        // This will drop down the size of the particle dramatically (removes all details)
        $type->stripImage();

        // Set particle compression to decrease filesize
        $type->setImageCompression(Imagick::COMPRESSION_JPEG);
        $type->setImageCompressionQuality(80);

        //$type->cropThumbnailImage(640, 1136);
        //$type->writeImage($path.$filename.'_th.'.$format);
        $type->cropThumbnailImage(90, 90);

        echo $path.$filename.'_thumb.'.$format.'<br>';
        $type->writeImage($path.$filename.'_thumb.'.$format);
    }
*/

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
        $model = new Type('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Type']))
            $model->attributes = $_GET['Type'];

        //var_dump($model);
        $this->render('index', array(
            'model' => $model,
        ));
        /*
		$dataProvider=new CActiveDataProvider('Type');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
        */
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Type('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Type']))
			$model->attributes=$_GET['Type'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Type the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Type::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Type $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
