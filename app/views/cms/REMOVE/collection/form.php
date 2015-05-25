<?php
/* @var $this CollectionController */
/* @var $model Collection */
/* @var $form CActiveForm */
?>

<h1><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> collection</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'collection-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_type'); ?>
		<?php echo $form->dropDownList($model, 'price_type', $model->getPriceTypes()); ?>
		<?php echo $form->error($model,'price_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->