<?php
/* @var $this CollectionController */
/* @var $model Collection */
/* @var $form CActiveForm */
?>

<h1><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> In-App</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inapp-form',
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
        <?php echo $form->labelEx($model,'bundle'); ?>
        <?php echo '<span>'.BUNDLE_IN_APP.'</span>'.$form->textField($model,'bundle',array('size'=>39,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'bundle'); ?>
    </div>

    <!--
    <div class="row">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatus()); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>
-->
<!--
    <div class="row">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model, 'type', $model->getTypeContent()); ?>
        <?php echo $form->error($model,'type'); ?>
    </div>
-->

    <div class="row left">
        <?php echo $form->labelEx($model, 'inAppTracks'); ?>
        <?php $this->widget('ext.EMultiSelect.EMultiSelect', array(
            'model' => $model,
            'attribute' => 'inAppTracks',
            'data' => CHtml::listData(Track::model()->published_inapp()->findAll(!$model->isNewRecord ? 'id != ' . $model->id : ''), 'id', 'title', 'collection.title'),
        )); ?>
        <?php echo $form->error($model, 'inAppTracks'); ?>
    </div>

    <div class="row right">
        <?php echo $form->labelEx($model, 'inAppPaintings'); ?>
        <?php $this->widget('ext.EMultiSelect.EMultiSelect', array(
            'model' => $model,
            'attribute' => 'inAppPaintings',
            'data' => CHtml::listData(Painting::model()->published_inapp()->findAll(!$model->isNewRecord ? 'id != ' . $model->id : ''), 'id', 'title'),
        )); ?>
        <?php echo $form->error($model, 'inAppParticles'); ?>
    </div>

    <div class="row left">
        <?php echo $form->labelEx($model, 'inAppParticles'); ?>
        <?php $this->widget('ext.EMultiSelect.EMultiSelect', array(
            'model' => $model,
            'attribute' => 'inAppParticles',
            'data' => CHtml::listData(Particle::model()->published_inapp()->findAll(!$model->isNewRecord ? 'id != ' . $model->id : ''), 'id', 'title'),
        )); ?>
        <?php echo $form->error($model, 'inAppParticles'); ?>
    </div>

    <div class="row right">
        <?php echo $form->labelEx($model, 'inAppVideos'); ?>
        <?php $this->widget('ext.EMultiSelect.EMultiSelect', array(
            'model' => $model,
            'attribute' => 'inAppVideos',
            'data' => CHtml::listData(Video::model()->published_inapp()->findAll(!$model->isNewRecord ? 'id != ' . $model->id : ''), 'id', 'title'),
        )); ?>
        <?php echo $form->error($model, 'inAppVideo'); ?>
    </div>

    <div class="row clear">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'description', 'options' => array(
            'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink',
            'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-Light'),
            'style_formats' => Yii::app()->params['style_formats'],
            'formats' => Yii::app()->params['formats'],
        ))); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'notes'); ?>
        <?php echo '<p class="info">This info doesn\'t show in the app</p>';?>
        <?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'notes', 'options' => array(
            'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink',
            'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-Light'),
            'style_formats' => Yii::app()->params['style_formats'],
            'formats' => Yii::app()->params['formats'],
        ))); ?>
        <?php echo $form->error($model, 'notes'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->