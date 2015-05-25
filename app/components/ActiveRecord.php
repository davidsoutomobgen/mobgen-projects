<?php

/**
 * This is the base model class .
 * @author David Souto <david.souto@mobgen.com>
 *
 */
class ActiveRecord extends CActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
	 */
	public static function model($className = __CLASS__) {

		return parent::model($className);
	}

	/**
	 * Initializes this model.
	 * This method is invoked when an AR instance is newly created and has
	 * its {@link scenario} set.
	 * You may override this method to provide code that is needed to initialize the model (e.g. setting
	 * initial property values.)
	 */
	public function init() {

		$this->attachbehavior("BusinessLogic", "BusinessLogicBehavior");
		$modelBehaviors = array(
            "Type" => array(
                "BusinessLogic" => "TypeBehavior",
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'date_created',
                    'updateAttribute' => 'date_updated',
                    'setUpdateOnCreate' => true,
                ),
            ),
            "Project" => array(
                "BusinessLogic" => "ProjectBehavior",
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'date_created',
                    'updateAttribute' => 'date_updated',
                    'setUpdateOnCreate' => true,
                ),
            ),
			"Track" => array(
				"BusinessLogic" => "TrackBehavior",
				'CTimestampBehavior' => array(
					'class' => 'zii.behaviors.CTimestampBehavior',
					'createAttribute' => 'date_created',
					'updateAttribute' => 'date_updated',
					'setUpdateOnCreate' => true,
				),
			),
            "Mobgenner" => array(
                "BusinessLogic" => "MobgennerBehavior",
                'CTimestampBehavior' => array(
                    'class' => 'zii.behaviors.CTimestampBehavior',
                    'createAttribute' => 'date_created',
                    'updateAttribute' => 'date_updated',
                    'setUpdateOnCreate' => true,
                ),
            ),

		);
		$className = $this->getModelName();
		//echo ($className."\n");
		if (isset($modelBehaviors[$className])) {
			foreach ($modelBehaviors[$className] as $key => $value) {
				$this->attachbehavior($key, $value);
			}
		}
	}

	/**
	 * TODO manage the croscutting model
	 *
	 *
	 * @param string $rel the name of the relation used to search. It can be also composed (ex: tags.lobs )
	 * @param mixed $attrs key-value array used for condition statement.
	 * @param mixed $opts key-value array to define query options.
	 * @author David Souto <david.souto@mobgen.com>
	 */
	public function searchByRelation($rel, $attrs, $opts = null) {

		$criteria = new CDbCriteria;
		$criteria->with = array($rel => array(
				'select' => false,
				'joinType' => 'INNER JOIN',
				));

		foreach ($attrs as $key => $value) {
			$criteria->addSearchCondition($key, $value);
		}

		$items = $this->findAll($criteria);
		return $items;
	}

	/**
	 *
	 */
	public function getIdsByRelationId($relationName,$relationsArray){
		$Ids= array();
		$criteria = new CDbCriteria;
		$criteria -> with = array("$relationName" => array(
							'select' => false, //the realted model won't be loaded
							'together' => true,
							'joinType' => 'INNER JOIN',
						));
		$criteria->select="id";
		$criteria->addInCondition($relationName.".id", $relationsArray);

		$obj = $this->findAll($criteria);
		foreach ($obj as $key => $value) {
			$Ids[] = $value->id;
		}

		return $Ids;
	}

	/**
	 *
	 */
	public function getObjectsByRelationId($relationName,$relationsArray){
		$criteria = new CDbCriteria;
		$criteria -> with = array("$relationName" => array(
							'select' => false, //the realted model won't be loaded
							'together' => true,
							'joinType' => 'INNER JOIN',
						));
		$criteria->select="*";
		$criteria->addInCondition($relationName.".id", $relationsArray);

		$obj = $this->findAll($criteria);

		return $obj;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/**
	 * Override this function if your model uses a non Numeric PK.
	 */
	public function isPk($pk) {
		return filter_var($pk, FILTER_VALIDATE_INT) !== false;
	}

	public function validateRelation($relationName) {
		if (is_null($relations = $this->relations()))
			return false;
		if (!isset($relations[$relationName]))
			return false;
		return true;
	}

	public function validateSubResource($subResourceName, $subResourceID = null) {

		if (is_null($relations = $this->relations()))
			return false;
		//die($relations[$subResourceName][0]);
		if (!isset($relations[$subResourceName]))
			return false;

		if ($relations[$subResourceName][0] != CActiveRecord::MANY_MANY && $relations[$subResourceName][0] != CActiveRecord::HAS_MANY)
			return false;
		if (!is_null($subResourceID))
			return filter_var($subResourceID, FILTER_VALIDATE_INT) !== false;

		return true;
	}

	/**
	 * This is broken out as a sperate method from actionRestView
	 * To allow for easy overriding in the controller
	 * adn to allow for easy unit testing
	 */
	public function doViewSubResource($id, $subResource, $subResourceID = null) {
		$subResourceRelation = $this->getActiveRelation($subResource);
		$subResourceModel = new $subResourceRelation->className;
		$this->_attachBehaviors($subResourceModel);

		$modelName = get_class($this->model);
		$newRelationName = "_" . $subResourceRelation->className . "Count";
		$this->getModel()->metaData->addRelation($newRelationName, array(
			$modelName::STAT,
			$subResourceRelation->className,
			$subResourceRelation->foreignKey
		));

		$model = $this->getModel()->with($newRelationName)->findByPk($id);
		$count = $model->$newRelationName;

		$results = $this->getModel()->with($subResource)->limit($this->restLimit)->offset($this->restOffset)->findByPk($id, array('together' => true));

		$results = $results->$subResource;

		$this->outputHelper('Records Retrieved Successfully', $results, $count, $subResourceRelation->className);
	}

	public function getModelName() {
		return get_class($this);
	}

	/**
	 *
	 * This is a simple function to return the array reppresentation of an object or collection of objects of the same class
	 *
	 *
	 * @return array Array of subarray. Every subarray is the key value rappresentation of an object
	 * @param mixed $names @see CActiveRecord::getAttributes();
	 * @param array $related @see ActiveRecord::getAttributesWithRelations()
	 * @param boolean $onlyId TODO comment
	 * @author David Souto <david.souto@mobgen.com>
	 * */
	public static function makeArray($items, $names = null, $related = null, $flat = false, $onlyId = false) {

		if (is_null($items) || $items===false)
			return null;

		if (!is_array($items))
			return $items->getAllAttributesWithRelations($names, $related, $flat, $onlyId);

		$arrayitems = array();

		if (empty($items))
			return $arrayitems;

		foreach ($items as $key => $value) {
			if (!is_array($value)){
				if ($arI = $value->getAllAttributesWithRelations($names, $related, $flat, $onlyId)){
					$arrayitems[] = $arI;
				}
			} else {
				$arrayitems[] = $value;
			}
		}
		return $arrayitems;
	}

    public function getTypeField()
    {
        return array(
            1 => "Checkbox (true/false)",
            2 => "Input",
            3 => "Textarea",
            4 => "Textarea Advanced",
            5 => "Link",
            6 => "Email",
        );
    }

    public function getActive()
    {
        return array(
            0 => 'Off',
            1 => 'On',
        );
    }

    public function getActiveText($value)
    {
        switch ($value) {
            case 0: return "Off"; break;
            case 1: return "On"; break;
            default: return false; break;
        }
    }

}
