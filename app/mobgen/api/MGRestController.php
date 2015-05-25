<?php

/**
 *
 * The Base controller for the Mobgen's REST API
 * TODO incapsulate the request logic in one class
 *
 * @author David Souto <david.souto@mobgen.com>
 */
class MGRestController extends MGApiController {

	/**
	 * @var string Rest API Configuration
	 *
	 * */
	public $defaultRestResourcesPath = "application.models";

	/**
	 * Request configuration
	 * */
	protected $restResource;
	protected $restResourceId = null;
	protected $restAction;
	protected $restSubResource;

	/**
	 * Operations' parameters
	 * */
	protected $paramsArray;
	protected $paramsError;
	protected $model = null;

	/**
	 * @var boolean used to skip the rest configuration
	 * */
	protected $skipREST = false;

	/*	 * Validate and load the REST from the resource and the action and eventually the ID
	 * with all the error handling needed
	 * It also log the REST action
	 * @param CAction $action
	 *
	 * @return bool
	 */

	protected function beforeAction($action) {
		if (!$this->skipREST) {
			$resManager = _app()->resourceManager;
			if (!$resManager->isInitialized) {
				$errorMessage = new MGApiMessage('Rest resource mapper not configured', array('Check your configuration inside rest-resource.php'));
				$this->respond(500, $errorMessage, $errorMessage);
			}

			//Check if the resource is allowed in the configuration file
			if (!$validResource = $resManager->isAllowedResource($_GET['resource'])) {
				$errorMessage = new MGApiMessage("Resource [{$_GET['resource']}] not found", array("The resource [{$_GET['resource']}] is not in the configuration file or it is deny"));
				$this->respond(404, $errorMessage, $errorMessage);
			}

			//Check if the class related to the resource is valid
			if (!$validClassResource = $resManager->isValidClass($validResource, $this->defaultRestResourcesPath)) {
				$errorMessage = new MGApiMessage("Class specified in the config file not found", array("The requested class for the resource [{$validResource}] is not in the configuration file or doesn't exists in the model",
					"If is configured without a specified class it will take the class exactly with the same name of the resource (CS)"));
				$this->respond(404, $errorMessage, $errorMessage);
			}

			$this->restResource = $validClassResource;

			if (isset($_GET['id'])) {
				$this->restResourceId = $_GET['id'];
				unset($_GET['id']);
			}

			//Load the model related to the class
			if (!$this->model = $resManager->loadModel($this->restResourceId, $this->restResource)) {
				$errorMessage = new MGApiMessage("The resource [$this->restResource $this->restResourceId] doesn't exists in the collection", array("The resource [$this->restResource $this->restResourceId] doesn't exists in the collection"));
				$this->respond(404, $errorMessage, $errorMessage);
			}

			$this->restAction = $action;

			//Load the action related to the class
			if (!$resManager->isAllowedAction($validResource, $this->restAction->id)) {
				$errorMessage = new MGApiMessage("The action [{$this->restAction->id}] is not allowed", array("The action [{$this->restAction->id}] for the resource [{$validResource}] is not specified in the config file or is not allowed"));
				$this->respond(404, $errorMessage, $errorMessage);
			}

			//TODO subresource validation
			//$this->prepareRestSubResource();
			//XXX use a behavior for this function to modularize query string protocol OR Put it in the request object
			if (!$this->prepareBaseRestParams() && $this->paramsError) {
				$this->respond(400, $this->paramsError['ErrorMessage'], $this->paramsError['ErrorMessage']);
			}

			$resId = $this->restResourceId ? $this->restResourceId : 'Entire collection';
			Yii::log('Rest Request - Action: ' . $action->id . ', Collection: ' . $this->restResource . ', Resource ID: ' . $resId, CLogger::LEVEL_INFO, 'api.rest');
		}

		return parent::beforeAction($action);
	}

	// ################# .:: GENERIC  OPERATIONS ::. #################

	public function actionList() {
		$model = $this->model;
		$items = $model->doList($this->paramsArray);
		$fields = true;
		if (isset($this->paramsArray['fields'])) {
			$fields = $this->paramsArray['fields'];
		}
		$itemsAr = ActiveRecord::makeArray($items, $fields);
		$this->respond(200, array("result"=>$itemsAr, "timestamp"=>time()));
	}


    public function actionShowAll() {
        $model = $this->model;
        $items = $model->doList($this->paramsArray);
        $fields = true;
        if (isset($this->paramsArray['fields'])) {
            $fields = $this->paramsArray['fields'];
        }
        $itemsAr = ActiveRecord::makeArray($items, $fields);
        foreach ($itemsAr as &$xx) {
            $xx['content'] = array();
            $i = 0;
            $cont = InAppTrack::model()->findAllByAttributes(array('inapp_id' => $xx['id']) );
            foreach ($cont as $cc){
                $xx['content'][$i]['id'] =  $cc->attributes['track_id'];
                $xx['content'][$i]['type_content'] =  $cc->attributes['type_content'];
                $i++;
            }
            $cont = InAppVideo::model()->findAllByAttributes(array('inapp_id' => $xx['id']) );
            foreach ($cont as $cc){
                $xx['content'][$i]['id'] =  $cc->attributes['video_id'];
                $xx['content'][$i]['type_content'] =  $cc->attributes['type_content'];
                $i++;
            }
            $cont = InAppPainting::model()->findAllByAttributes(array('inapp_id' => $xx['id']) );
            foreach ($cont as $cc){
                $xx['content'][$i]['id'] =  $cc->attributes['painting_id'];
                $xx['content'][$i]['type_content'] =  $cc->attributes['type_content'];
                $i++;
            }
            $cont = InAppParticle::model()->findAllByAttributes(array('inapp_id' => $xx['id']) );
            foreach ($cont as $cc){
                $xx['content'][$i]['id'] =  $cc->attributes['particle_id'];
                $xx['content'][$i]['type_content'] =  $cc->attributes['type_content'];
                $i++;
            }
        }

        $this->respond(200, array("result"=>$itemsAr, "timestamp"=>time()));
    }
	/**
	 * Renders View of record as json
	 * Or Custom method
	 *
	 */
	public function actionView() {
		$model = $this->model;
		$id = $this->restResourceId;
		if ($model->isPk($id) && is_null($this->restSubResource))
			$items = $model->doView($this->paramsArray);
		else {
			die("Currently we can't handle the subresource");
			// if ($model -> isPk($id) && !is_null($this -> restSubResource)) {
			// if ($model -> validateSubResource($this -> restSubResource))
			// $model -> doViewSubResource($id, $this -> restSubResource);
			// else
			// $this -> triggerCustomRestGet($this -> restSubResource, array($id));
			//}
		}
		$fields = true;
		if (isset($this->paramsArray['fields'])) {
			$fields = $this->paramsArray['fields'];
		}
		$itemsAr = ActiveRecord::makeArray($items, $fields);
		$this->respond(200, $itemsAr);
	}

	/**
	 * Creates new record
	 */
	public function actionCreate() {
		$model = $this->model;
		$model = $model->doCreate($this->data());

		$fields = true;
		if (isset($this->paramsArray["fields"])) {
			$fields = $this->paramsArray["fields"];
		}
		$modelArray = ActiveRecord::makeArray($model, $fields);
		if (!$modelArray) {
			$errorMessage = new MGApiMessage("Object has not been creted", array('Check if the fields are correct'));
			$this->respond(400, $errorMessage, $errorMessage);
		} else {
			$this->respond(201, $modelArray);
		}
	}

	/**
	 * Update a record
	 */
	public function actionUpdate() {
		$model = $this->model;
		$model = $model->doUpdate($this->data());
		$fields = true;
		if (isset($this->paramsArray["fields"])) {
			$fields = $this->paramsArray["fields"];
		}
		$modelArray = ActiveRecord::makeArray($model, $fields);

		if (!$modelArray) {
			$errorMessage = new MGApiMessage("Object has not been updated", array('Check if the fields are correct'));
			$this->respond(400, $errorMessage, $errorMessage);
		} else {
			$this->respond(200, $modelArray);
		}
	}

	/**
	 * Update a record
	 */
	public function actionDelete() {
		$model = $this->model;
		$model->doDelete();

		$this->respond(200, "");
	}

	/**
	 * Bulk Delete
	 */
	public function actionBulkUpdate() {
		die("Currently we can't manage the bulk operations");
	}

	/**
	 * Bulk Delete
	 */
	public function actionBulkDelete() {
		die("Currently we can't manage the bulk operations");
	}

	/**
	 * Options //TODO write a logic
	 */
	public function actionOptions() {
		$this->respond(200, "Let's allowed the options to pass");
	}

	/**
	 *    Validate the subresource requested in a rest call
	 *
	 * @return boolean True if the resource is valid false otherwise
	 *
	 * @author David Souto <david.souto@mobgen.com>
	 * */
	private function prepareRestSubResource() {
		if (isset($_GET['subResource'])) {
			$this->restSubResource = $_GET['subResource'];
			unset($_GET['subResource']);
		}

		return true;
	}

	/**
	 * This function validates and prepares the base parameters for the Business logic.
	 * To be flexible on the number and on the type of the parameters, this function
	 * simply prepare a array of these ones. Every model can manage the parameters as it's better for its
	 *
	 * TODO CROSSCUTTING MODEL
	 * @param integer limit
	 * @param integer offset
	 * @param JSON filter
	 * @param mixed fields (comma separated)
	 *
	 * @author David Souto <david.souto@mobgen.com>
	 * */
	private function prepareBaseRestParams() {

		$paramsArray = array();

		if (isset($_GET['timestamp'])) {
			if (!is_numeric($timestamp = $_GET['timestamp'])) {
				$this->paramsError = array('ErrorMessage' => 'Param Timestamp is not valid. Please check if it\'s numeric.');
				return false;
			}
			$paramsArray['timestamp'] = $timestamp;
			unset($_GET['timestamp']);
		}

		if (isset($_GET['filter'])) {
			if (!$jsonDecode = CJSON::decode($_GET['filter'])) {
				$this->paramsError = array('ErrorMessage' => 'Param Filter not valid. Please check the JSON syntax.');

				return false;
			}
			$paramsArray['filter'] = $jsonDecode;
			unset($_GET['filter']);
		}

		if (isset($_GET['limit'])) {
			if (!is_numeric($limit = $_GET['limit'])) {
				$this->paramsError = array('ErrorMessage' => 'Param Limit not valid. Please check if it\'s numeric.');
				return false;
			}
			$paramsArray['limit'] = $limit;
			unset($_GET['limit']);
		}

		if (isset($_GET['offset'])) {
			if (!is_numeric($offset = $_GET['offset'])) {
				$this->paramsError = array('ErrorMessage' => 'Param Offset not valid. Please check if it is numeric.');
				return false;
			}
			$paramsArray['offset'] = $offset;
			unset($_GET['offset']);
		}

		if (isset($_GET['fields'])) {
			$paramsArray['fields'] = explode(',', $_GET['fields']);
			unset($_GET['fields']);
		}

		//All the rest
		foreach ($_GET as $key => $value) {
			$paramsArray[$key] = $value;
		}

		$this->paramsArray = $paramsArray;
	}

}
