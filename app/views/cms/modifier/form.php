<?php
/* @var $this ModifierController */
/* @var $model Modifier */
/* @var $form CActiveForm */
?>

<h1><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> modifier</h1>

<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'modifier-form',
		'enableAjaxValidation' => false,
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<p><strong><?php echo $model->description; ?></strong></p>

	<div class="row">
		<?php echo $form->labelEx($model, 'value'); ?>
		<?php echo $form->numberField($model, 'value', array('min' => -100, 'max' => 100, 'size' => 4)); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiSlider', array(
			'value' => $model->value ? : 0,
			'options' => array(
				'min' => -100,
				'max' => 100,
				'slide' => "js:function( event, ui ) {
						$('#Modifier_value').val( ui.value );
					}",
			),
			'htmlOptions' => array(
				'style' => 'width:200px;margin-left:10px;display:inline-block;',
			),
		));
		?>
		<?php echo $form->error($model, 'value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->