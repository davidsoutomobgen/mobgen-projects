<?php

class ProjectController extends Controller
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
				'actions'=>array('index','view', 'list'),
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

        $attribs = array('project_id'=>$id);
        $ids_new_field = NewFieldProject::model()->findAllByAttributes($attribs);
        $new_field = '';
        foreach ($ids_new_field as $t) {
            $attribs = array('table'=>'project', 'id'=>$t->attributes['new_field_id']);
            $criteria = new CDbCriteria(array('order'=>'position DESC'));
            $new_field[] = NewField::model()->findAllByAttributes($attribs, $criteria);
        }


        $client = new Client('search');
        $client->unsetAttributes();  // clear any default values
        //if (isset($_GET['Project']))
            //$model->attributes = $_GET['Project'];

        //echo '<pre>';print_r($new_field);echo '</pre>'; die;

		$this->render('full_view',array(
			'model'=>$this->loadModel($id),
            'new_field'=>$new_field,
            'client'=>$client,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Project;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

        $this->_process($model);
        $project_types = array();

        $attribs = array('table'=>'project');
        $criteria = new CDbCriteria(array('order'=>'position DESC'));
        $new_field = NewField::model()->findAllByAttributes($attribs, $criteria);

        //$new_field = NewField::model()->findAllByAttributes(array('table'=>'project'));
//var_dump($new_field[0]->attributes); die;

        $this->render('create',array(
            'model'=>$model,
            'project_types'=>$project_types,
            'new_field'=>$new_field//[0]->attributes
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

        $pt_array = ProjectType::model()->findAllByAttributes(array('project_id'=>$id));
        $project_types = array();

        foreach ($pt_array as $tt) {
            $project_types[] = $tt->attributes['type_id'];
        }
        $new_field = '';

        $attribs = array('project_id'=>$model->id);
        $ids_new_field = NewFieldProject::model()->findAllByAttributes($attribs);
        foreach ($ids_new_field as $t) {
            $attribs = array('table'=>'project', 'id'=>$t->attributes['new_field_id']);
            $criteria = new CDbCriteria(array('order'=>'position DESC'));
            $new_field[] = NewField::model()->findAllByAttributes($attribs, $criteria);
        }

		$this->render('update',array(
			'model'=>$model,
            'project_types'=>$project_types,
            'new_field'=>$new_field
		));
	}

    private function _process($model) {

        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];

            $model->project = CUploadedFile::getInstance($model, 'logo');
            if ($model->project){
                $model->logo = uniqid(mt_rand()).'_'.str_replace(' ', '_', $model->project->name);
                $extension = end(explode(".", $model->logo)); //substr($model->logo, -3);
                $filename = basename($model->logo, ".".$extension);
            }

            //echo '<pre>';print_r($model->attributes); echo '</pre>';die;
            //Error here - if i don't put this wrong save model
            $model->additional_information = $_POST['Project']['additional_information'];
            $model->onboarding_document = $_POST['Project']['onboarding_document'];

            if ($model->save()) {
                if ($model->project) {
                    $model->project->saveAs($model->typePath . $model->logo);
                    $this->_processLogo($filename, $model->typePath, $extension);
                }
                ProjectType::model()->deleteAllByAttributes(array('project_id'=>$model->id));
                //var_dump($_POST['Project']); die;

                //ProjectType
                if (isset($_POST['Project']['projectType'])) {
                    $types = $_POST['Project']['projectType'];
                    foreach ($types as $tt){
                        $projectType = new ProjectType();
                        $projectType->project_id = $model->id;
                        $projectType->type_id = $tt;
                        $projectType->save();
                    }
                }

                //Gestion NewFields
                if (isset($_POST['NewField'])) {
                    $fields = $_POST['NewField'];
                    foreach ($fields as $k=>$ff){
                        $attribs = array('view_id'=>$model->id, 'new_field'=>$k);
                        $criteria = new CDbCriteria(array('order'=>'id DESC'));
                        $field = NewFieldValues::model()->findAllByAttributes($attribs, $criteria);

                        if (!empty($field)) {
                            $newField = NewFieldValues::model()->findByPk($field[0]->attributes['id']);
                            $newField->value = $ff;
                        }
                        else {
                            $newField = new NewFieldValues();
                            $newField->new_field = (int) $k;
                            $newField->view_id = $model->id;
                            $newField->value = $ff;
                        }
                        $newField->save();



                    }
                }

                $this->redirect(array('/cms/project/view/'.$model->id));
            }
        }
    }


    /**
     * Creates three preview particles from an particle or document
     *
     * @param string $particle
     * @param string $filename
     */
    private function _processLogo($filename, $path, $format='jpg') {
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

        //echo $path.$filename.'_thumb.'.$format.'<br>';
        $type->writeImage($path.$filename.'_thumb.'.$format);
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
	public function actionList()
	{
        $model = new Project('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Project']))
            $model->attributes = $_GET['Project'];

        //var_dump($model);
        $this->render('list', array(
            'model' => $model,
        ));
	}

    public function actionIndex()
    {
        $attribs = array('deleted'=>0);
        $model = Project::model()->findAllByAttributes($attribs);

        $this->render('index', array(
            'model' => $model,
        ));
    }
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Project('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Project']))
			$model->attributes=$_GET['Project'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Project the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Project::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Project $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
