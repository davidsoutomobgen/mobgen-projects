<?php
/* @var $this ImageController */
/* @var $model Image */
/* @var $form CActiveForm */
?>

<h1><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> particle</h1>

<div class="form">

	<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'image-form',
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
        <?php echo $form->labelEx($model,'in_app'); ?>
        <?php echo $form->dropDownList($model, 'in_app', $model->getType()); ?>
        <?php echo $form->error($model,'in_app'); ?>
    </div>

	<div class="row">
		<?php
		if ($model->filename) {
			echo CHtml::image(Utils::imageUrl('../particles/flux' . DS . $model->thumb), '', array('style'=>'margin:10px 0 5px;'));
		}
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'particle'); ?>
		<?php echo $form->fileField($model, 'particle'); ?>
		<?php echo $form->error($model, 'particle'); ?>
		<p class="note">
			<small>All formats to particles are allowed.</small>
		</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->