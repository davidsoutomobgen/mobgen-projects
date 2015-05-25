<?php
/* @var $this TypeController */
/* @var $model Type */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title">
		        <span class="icon"><i class="fa fa-align-justify"></i></span>
                <h5><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?></h5>
            </div>
            <div class="widget-content nopadding">
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'type-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation'=>false,
                    'htmlOptions'=>array(
                          'class'=>'form-horizontal',
                          'enctype' => 'multipart/form-data'
                    ),
                )); ?>

                <?php echo $form->errorSummary($model); ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model,'name', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'name',array('class' => 'form-control input-sm', 'placeholder' => 'Name', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'name'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model,'description', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'description',array('class' => 'form-control input-sm', 'placeholder' => 'Description', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'description'); ?>
                </div>


                <div class="form-group">
                    <?php echo $form->labelEx($model,'logo', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->fileField($model, 'logo'); ?>
                    </div>
                    <?php echo $form->error($model,'logo'); ?>
                    <span class="row">
                    <?php
                    if ($model->logo) {
                        echo $form->hiddenField($model,'logo',array('value'=>$model->logo));
                        echo '<div class="col-sm-9 col-md-9 col-lg-10">';
                        echo CHtml::image(Utils::imageUrl('..' . DS . 'files' . DS . 'types' . DS . $model->logo), '', array('style'=>'margin:10px 0 5px;'));
                        echo '</div>';
                    }
                    ?>
                </span>
                </div>

                <div class="form-group">
                    <div class="no-label col-sm-9 col-md-9 col-lg-10">
                        <p class="note text-danger">Fields with <span class="required">*</span> are required.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-sm')); ?> or <a href="/cms/type/index" class="text-danger" href="#">Cancel</a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>