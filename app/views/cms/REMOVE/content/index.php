<?php
/* @var $this ContentController */
/* @var $model Content */
/* @var $form CActiveForm */
?>

<h1>Update Content</h1>

<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'content-form',
		'enableAjaxValidation' => false,
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'tag'); ?>
		<?php echo $form->textField($model, 'tag'); ?> <small>Used for the Instagram gallery</small>
		<?php echo $form->error($model, 'tag'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'biography'); ?>
		<?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'biography', 'options' => array(
			'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink | fontselect | fontsizeselect',
			'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-LightItalic'),
			'style_formats' => Yii::app()->params['style_formats'],
			'formats' => Yii::app()->params['formats'],
		))); ?>
		<?php echo $form->error($model, 'biography'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Update', array('class' => 'button')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->