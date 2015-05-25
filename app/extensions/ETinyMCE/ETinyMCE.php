<?php

/**
 * Class ETinyMCE
 * Yii wrapper for the TinyMCE WYSIWYG Editor
 *
 * @author David Souto <david.souto@mobgen.com>
 * @date 30-04-2014
 */
class ETinyMCE extends CWidget
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
	 * @var string
	 */
	public $value;
	/**
	 * @var array
	 */
	public $options = array();
	/**
	 * @var array
	 */
	public $htmlOptions = array();

	/**
	 * @var array
	 */
	private $_defaultOptions = array(
		'plugins' => 'autoresize, link',
		'menubar' => false,
		'block_formats' => 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3',
		'toolbar' => 'undo redo | formatselect | bold italic underline strikethrough | bullist numlist outdent indent | link unlink',
		'statusbar' => true,
	);
	/**
	 * @var string
	 */
	private $_assetsUrl;

	/**
	 * This method is called by CController::beginWidget()
	 */
	public function init()
	{
		Yii::app()->getClientScript()->registerCoreScript('jquery');
		Yii::app()->getClientScript()->registerScriptFile($this->getAssetsUrl() . DIRECTORY_SEPARATOR . 'tinymce.min.js');
	}

	/**
	 * This method is called by CController::endWidget()
	 */
	public function run()
	{
		list($name, $id) = $this->resolveNameID();

		$this->options = CMap::mergeArray($this->_defaultOptions, $this->options);
		$this->options['selector'] = "#{$id}";

		$options = CJavaScript::encode($this->options);
		Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, "tinymce.init({$options});");

		if ($this->hasModel())
			echo CHtml::activeTextArea($this->model, $this->attribute, $this->value, $this->htmlOptions);
		else
			echo CHtml::textArea($name, $this->value, $this->htmlOptions);
	}

	/**
	 * @return mixed
	 */
	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null)
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.ETinyMCE.assets'), false, -1, YII_DEBUG);

		return $this->_assetsUrl;
	}

	/**
	 * @return array the name and the ID of the input.
	 * @throws CException
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