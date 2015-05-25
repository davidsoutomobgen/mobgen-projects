<?php

/**
 * JColorPicker class file.
 *
 * A typical usage of JColorPicker is as follows:
 * <pre>
 * $this->widget('application.extensions.colorpicker.JColorPicker', array(
 *     'model' => $model,
 *     'attribute' => 'base_style',
 *     'htmlOptions' => array(),
 * ));
 * </pre>
 *
 * @author jerry2801 <jerry2801@gmail.com>
 * @author David Souto <david.souto@mobgen.com>
 */
class JColorPicker extends CWidget
{
	public $model;
	public $attribute;
	public $baseUrl;
	public $options = array();
	public $htmlOptions = array();
	public $selectorHtmlOptions = array();

	public function init()
	{
		$activeId = CHtml::activeId($this->model, $this->attribute);

		$defaults = array(
			'color' => '#' . CHtml::value($this->model, $this->attribute),
			'onBeforeShow' => new CJavaScriptExpression("function () {}"),
			'onShow' => new CJavaScriptExpression("function () {}"),
			'onHide' => new CJavaScriptExpression("function () {}"),
			'onChange' => new CJavaScriptExpression("function (hsb, hex, rgb) {
				$('#{$activeId}').val(hex);
				$('#{$activeId}').prev('.colorpicker_select').css('backgroundColor', '#' + hex);
			}"),
			'onSubmit' => new CJavaScriptExpression("function(hsb, hex, rgb, el) {
				$('#{$activeId}').val(hex);
				$('#{$activeId}').prev('.colorpicker_select').ColorPickerHide();
			}"),
		);
		$options = CJavaScript::encode(CMap::mergeArray($defaults, $this->options));

		$dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$this->baseUrl = Yii::app()->getAssetManager()->publish($dir, false, -1, YII_DEBUG);

		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($this->baseUrl . '/js/colorpicker.js');
		$cs->registerCssFile($this->baseUrl . '/css/colorpicker.css');
		$cs->registerScript($activeId . '_script', "$('#{$activeId}').prev('.colorpicker_select').ColorPicker({$options});");
	}

	public function run()
	{
		$preview = CHtml::tag('div', array(
			'class' => 'colorpicker_select',
			'style' => 'background-color:#' . CHtml::value($this->model, $this->attribute),
		), "&nbsp;");
		$field = CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
		echo CHtml::tag('div', array('class' => 'colorpicker_wrapper'), $preview . $field);
	}
}