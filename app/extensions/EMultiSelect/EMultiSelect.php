<?php

/**
 * Class EMultiSelect
 * Widget for selecting multiple options in a listBox in a user friendly way
 *
 * @author David Souto <david.souto@mobgen.com>
 * @date 21-03-2014
 */
class EMultiSelect extends CWidget
{
	/**
	 * @var string
	 */
	public $model;
	/**
	 * @var string
	 */
	public $attribute;
	/**
	 * @var string
	 */
	public $name;
	/**
	 * @var array
	 */
	public $select = array();
	/**
	 * @var array
	 */
	public $data = array();
	/**
	 * @var array
	 */
	public $selected = array();
	/**
	 * @var array
	 */
	public $options = array();
	/**
	 * @var array
	 */
	public $htmlOptions = array();

	/**
	 * @var string
	 */
	private $_assetsUrl;

	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerScriptFile($this->getAssetsUrl() . DIRECTORY_SEPARATOR . 'jquery.emultiselect.js');
		Yii::app()->clientScript->registerCssFile($this->getAssetsUrl() . DIRECTORY_SEPARATOR . 'jquery.emultiselect.css');

		$this->htmlOptions = array_replace(array(
			'style' => 'display:none;',
			'multiple' => true,
		), $this->htmlOptions);
	}

	/**
	 * This method is called by CController::endWidget()
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id'] = $id;
		if (isset($this->htmlOptions['name']))
			$name = $this->htmlOptions['name'];

		$options=CJavaScript::encode($this->options);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"jQuery('#{$id}').EMultiSelect({$options});");

		if ($this->hasModel())
			echo CHtml::activeListBox($this->model, $this->attribute, $this->data, $this->htmlOptions);
		else
			echo CHtml::listBox($this->name, $this->select, $this->data, $this->htmlOptions);

		$this->render('widget');
	}

	/**
	 * @return mixed
	 */
	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null)
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.EMultiSelect.assets'), false, -1, YII_DEBUG);
		return $this->_assetsUrl;
	}

	/**
	 * @throws CException
	 * @return array the name and the ID of the input.
	 */
	protected function resolveNameID()
	{
		if ($this->name !== null)
			$name = $this->name;
		elseif (isset($this->htmlOptions['name']))
			$name = $this->htmlOptions['name'];
		elseif ($this->hasModel())
			$name = CHtml::activeName($this->model, $this->attribute);
		else
			throw new CException(Yii::t('zii', '{class} must specify "model" and "attribute" or "name" property values.', array('{class}' => get_class($this))));

		if (($id = $this->getId(false)) === null) {
			if (isset($this->htmlOptions['id']))
				$id = $this->htmlOptions['id'];
			else
				$id = CHtml::getIdByName($name);
		}

		return array($name, $id);
	}

	/**
	 * @return boolean whether this widget is associated with a data model.
	 */
	protected function hasModel()
	{
		return $this->model instanceof CModel && $this->attribute !== null;
	}
}