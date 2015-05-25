<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<h1><?php echo $model->isNewRecord ? 'Add' : 'Update'; ?> newsitem</h1>

<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'news-form',
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row">
		<?php if ($model->image) {
			echo CHtml::image(Utils::imageUrl('news' . DS . $model->image), '', array('style' => 'margin:10px 0 5px;'));
		} ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'file'); ?>
		<?php echo $form->fileField($model, 'file'); ?>
		<?php echo $form->error($model, 'file'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'text'); ?>
		<?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'text', 'options' => array(
			'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink | fontselect | fontsizeselect',
			'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-LightItalic'),
			'style_formats' => Yii::app()->params['style_formats'],
			'formats' => Yii::app()->params['formats'],
		))); ?>
		<?php echo $form->error($model, 'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->