<?php

/**
 * This class define the basic logic for every active record
 *
 * @author David Souto <david.souto@mobgen.com>
 */
class BusinessLogicBehavior extends CActiveRecordBehavior {

	/**
	 * This recursive function extend the getAttributes capabilities watching in the ActiveRecord relations.
	 * The are two mode:
	 * - flat -> it's return a one-dimensional array  - this mode only with HAS-ONE and BELONGS-to relations
	 *           and to avoid name conflicts, the name of the related object's attributes are prefixed with the relation name (camelCase)
	 * - nested -> it's return a multidimensional array, all the relations are in a nested array.
	 *
	 * TODO: Enhance this function to combine flat and nested mode
	 * TODO: Simplify the parameter $related
	 *
	 * @param mixed $name @see CActiveRecord::getAttributes()
	 * @param array $related Key-Value array of relation; Key is the name of a relation, value is an array ($name, $related) for the recursion.
	 * 							EX: array(..., tags =>array(array(id,name),array(category =>...) ) , ...)
	 * @param boolean $flat to switch flat and nested mode
	 * @param boolean $onlyId TODO comment
	 *
	 * @author David Souto <david.souto@mobgen.com>
	 */
	public function getAllAttributesWithRelations($names = true, $related = null, $flat = false, $onlyId = false) {
		$mainArray = $this->getAllAttributes($names);

		//UNSET NULL VALUE
		foreach ($mainArray as $key1 => $value) {
			if (is_null($value))
				unset($mainArray[$key1]);
		}

		if (!$related)
			return $mainArray;

		foreach ($related as $relation => $opts) {

			$nameR = $opts[0];
			$relatedR = $opts[1];

			// NESTED - if $this->$relation is an Array then the nested mode is mondatory
			if (!$flat || is_array($this->owner->$relation)) {

				if (is_array($this->owner->$relation)) {
					//Array of ModelArray
					$relatedArray = array();

					for ($i = 0; $i < count($this->owner->$relation); $i++) {
						$relatedArrayModel = $this->owner->$relation;
						$relatedModel = $relatedArrayModel[$i];
						if ($onlyId) {//TODO teke out this behavior
							if (is_numeric($relatedModel->id)) {
								$curid = $relatedModel->id + 0;
							}
							$relatedArray[] = $curid;
						} else {
							$relatedArray[] = $relatedModel->getAllAttributesWithRelations($nameR, $relatedR, $flat, $onlyId);
						}
					}
					$mainArray[$relation] = $relatedArray;
				} else {
					$mainArray[$relation] = $this->owner->$relation->getAllAttributesWithRelations($nameR, $relatedR, $flat, $onlyId);
				}
			}

			//FLAT
			else {
				$relatedArray = $this->owner->$relation->getAllAttributesWithRelations($nameR, $relatedR, $flat);
				foreach ($relatedArray as $key => $value) {
					$newName = $relation . ucfirst($key);
					$mainArray[$newName] = $value;
				}
			}
		}
		return $mainArray;
	}

	/**
	 * This Function improve the CActiveRecord->getAttributes()
	 * forcing the data types and return automatcly also the object's properties (no DB attribute)
	 * @see CActiveRecord::getAttributes()
	 * @author David Souto <david.souto@mobgen.com>
	 */
	public function getAllAttributes($names = true) {
		$arrayKV = $this->owner->getAttributes($names);

		//Define operation variable needed for the actual object (1 = New | 2 = Update | 3 = Delete)
		if (_param('customizedScenario') == 'synchronize') {
			if (isset($arrayKV['date_created']) && $arrayKV['date_created']) {
				$arrayKV['operation'] = 1;
			}

			if (isset($arrayKV['date_updated']) && $arrayKV['date_updated']) {
				$arrayKV['operation'] = 2;
			}

			if (isset($arrayKV['date_deleted']) && $arrayKV['date_deleted']) {
				$arrayKV['operation'] = 3;
			}
		}

		return $this->typeForce($arrayKV);
	}

	/**
	 *
	 * This function force the values of an array to their types by the TableSchema
	 * Nothing is done about the object's properties (no DB attribute)
	 * @author David Souto <david.souto@mobgen.com>
	 * */
	public function typeForce($arrayKV) {
		$table = $this->owner->getMetaData()->tableSchema;

		foreach ($arrayKV as $key => $value) {
			if (($column = $table->getColumn($key)) !== null && $value !== null) {
				$arrayKV[$key] = $column->typecast($value);
				//print_r($column);
			}
		}
		return $arrayKV;
	}

	/**
	 * *****************************************************************************************
	 * *****************************************************************************************
	 * OVERIDE THE METHODS BELOW IN YOUR MODEL TO REMOVE/ALTER DEFAULT FUNCTIONALITY
	 *
	 * TODO make these methods static
	 *
	 * *****************************************************************************************
	 * *****************************************************************************************
	 */

	/**
	 *
	 * @param $paramsArray Array of
	 * */
	public function doList($paramsArray) {
		$criteria = $this->makeCriteria($paramsArray);
		$items = $this->owner->findAll($criteria);

		return $items;
	}

	public function doView($paramsArray, $scenario = 'view') {
		$this->owner->setScenario($scenario);
		return $this->owner;
	}

	/**
	 * Creates a new Entity in the DB
	 * @return boolean true if the entity is saved false otherwise (the errors are available in model::errors)
	 */
	public function doCreate($objArray, $validate = true, $scenario = 'create') {
		$this->owner->setScenario($scenario);
		$this->owner->attributes = $objArray;
		if ($this->owner->save($validate))
			return $this->owner;
		else
			return false;
	}

	public function doUpdate($objArray, $validate = true, $scenario = 'update') {
		$this->owner->setScenario($scenario);
		$this->owner->attributes = $objArray;
		if ($this->owner->save($validate))
			return $this->owner;
		else
			return false;
	}

	public function doDelete($scenario = 'delete') {
		$this->owner->setScenario($scenario);
		if ($this->owner->delete())
			return true;
		else
			return false;
	}

	public function doPublish() {
		$this->owner->status = RecordStatus::ENABLED;
		$this->owner->save();
	}

	public function doUnpublish() {
		$this->owner->status = RecordStatus::DISABLED;
		$this->owner->save();
	}

	public function doSoftDelete() {
		$this->owner->status = RecordStatus::DELETED;
		$this->owner->save();
	}

	public function afterFind() {
		if (_param('customizedScenario')) {
			$this->owner->setScenario(_param('customizedScenario'));
		}
	}

	/**
	 * TODO Use fields to optimize the query
	 * TODO CROSSCUTTING MODEL: !security EX:isAttributeSafe()
	 *
	 * FIXME Problem with nested relation
	 * FIXME Error when try to do manytomany/hasmany query. Now work only with belong_to
	 *  N.B.: if you use the filter param to filter by relations, you won't get the related model
	 *
	 * @param CDbCriteria $criteria
	 * */
	protected function makeCriteria($paramsArray) {

		$criteria = new CDbCriteria;

		if (isset($paramsArray["timestamp"])) {
			$criteria->condition = "date_updated > {$paramsArray["timestamp"]}";
		}

		if (isset($paramsArray["filter"]))
			$filter = $paramsArray["filter"];

		if (isset($paramsArray["limit"])) {
			$criteria->limit = $paramsArray["limit"];
			if (isset($paramsArray["offset"]))
				$criteria->offset = $paramsArray["offset"];
		}

		if (empty($filter))
			return $criteria;

		//_dump($filter,true);
		foreach ($filter as $key => $value) {

			$relArray = explode(".", $key);
			//used to filter the related model
			$valArray = explode(",", $value);
			//used for IN statement
			////////////////////////////////////////////////////////

			if (count($relArray) > 1) {// TODO redefine this function to simplify the code
				if ($this->owner->validateRelation($relArray[0])) {
					$criteria->with = array(
						$relArray[0] => array(
							'select' => false, //the related model won't be loaded
							'together' => true,
							'joinType' => 'INNER JOIN',
						)
					);
					if (count($valArray) > 1)
						$criteria->addInCondition($key, $valArray);
					else
						$criteria->compare($key, $value);
				}
			} else {
				if (count($valArray) > 1)
					$criteria->addInCondition($key, $valArray);
				else
					$criteria->compare('t.' . $key, $value);
			}
			/////////////////////////////////////////////////////////////////////////////
		}

		return $criteria;
	}

}