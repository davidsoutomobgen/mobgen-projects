<?php
/**
 *
 * The Resource manager to check which rosources and actions are allowed
 * according to the config file
 *
 * @author Luca Temperini
 * @since 2-5-2013
 */
class ResourceManager extends CApplicationComponent
{

	public $resources = null;

	/**Initialize the AppComponent to check the integrity of the rest-resources.php
	 * @return bool|void
	 */
	public function init()
	{
		if (!isset($this->resources) || !is_array($this->resources) || empty($this->resources)) {
			return false;
		}

		return parent::init();
	}

	/**According to the configuration file check if the requested resource is in the conf file
	 * @param $resourceRequested comma separated if we accept more than one name for a resource
	 *
	 * @return bool|int|string False if not allowed otherwise the key of the array needed for the next step(isValidClass)
	 */
	public function isAllowedResource($resourceRequested)
	{
		foreach ($this->resources as $resource => $details) {
			if ('*' == $resource) {
				if (isset($details[0]) && 'deny' == $details[0]) {
					return false;
				}

				return $resourceRequested;
			}

			//Remove all the spaces inside the name of the resources
			$resources = explode(',', $resource);
			$normResources = array();
			foreach ($resources as $res) {
				$normResources[] = strtolower(trim($res));
			}

			if (in_array(strtolower($resourceRequested), $normResources)) {
				if (isset($this->resources[$resource][0]) && 'deny' == $this->resources[$resource][0]) {
					return false;
				}

				return $resource;
			}
		}

		return false;
	}

	/** Check if the class passed is valid and exists in our model.
	 * If not specified will take the resource name passed (case sensitive)
	 * @param $resource
	 * @param $defaultRestResourcesPath
	 *
	 * @return bool
	 */
	public function isValidClass($resource, $defaultRestResourcesPath)
	{
		$class = isset($this->resources[$resource]['class']) ? $this->resources[$resource]['class'] : $resource;

		return file_exists(Yii::getPathOfAlias("{$defaultRestResourcesPath}.{$class}") . '.php') ? $class : false;
	}

	/**Return The model related to this restResource.
	 * if the $id is not null, returns the data model based on the primary key given in the GET variable.
	 * else returns the static model
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param $restResourceId
	 * @param $modelName
	 *
	 * @return mixed
	 */
	public function loadModel($restResourceId, $modelName)
	{
		if ($restResourceId != null) {
			$model = $modelName::model()->findByPk($restResourceId);
		} else {
			$model = new $modelName;
		}

		return $model;
	}

	/** Check if the action is allowed according to the conf file.
	 * if the action value is a * every action are allowed
	 * each action could be setted as deny or allowed so could assume the value as $key or $value
	 * @param $resource
	 * @param $action
	 *
	 * @return bool
	 */
	public function isAllowedAction($resource, $action)
	{
		if (!isset($this->resources[$resource]['actions']) || '*' == $this->resources[$resource]['actions']) {
			return true;
		}

		foreach ($this->resources[$resource]['actions'] as $confAction => $details) {
			if ($details === $action) {
				return true;
			}

			if ($confAction === $action) {
				if ($details == 'deny') {
					return false;
				} else {
					//TODO: add here the logic to check inside every single action
					return true;
				}
			}
		}

		return false;
	}
}
