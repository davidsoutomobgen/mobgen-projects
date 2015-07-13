<?php
/* @var $this NewFieldController */
/* @var $model NewField */
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
                    'id'=>'new-field-form',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'enableAjaxValidation'=>false,
                    'htmlOptions'=>array(
                        'class'=>'form-horizontal',
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
                    <?php echo $form->labelEx($model,'label', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'label',array('class' => 'form-control input-sm', 'placeholder' => 'Label', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'label'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model,'type_field', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->dropDownList($model, 'type_field', $model->getTypeField(),array('class' => 'form-control input-sm')); ?>
                    </div>
                    <?php echo $form->error($model,'type_field'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model,'table', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->dropDownList($model, 'table', $tables,array('class' => 'form-control input-sm')); ?>
                        <?php echo '<span>Only available for project\'s table</span>'; ?>

                    </div>
                    <?php echo $form->error($model,'table'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model,'position', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'position', array('class' => 'form-control input-sm', 'placeholder' => 'Label', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'position'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'newFieldProjects', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10 selectCombo">

                    <?php $this->widget('ext.EMultiSelect.EMultiSelect', array(
                        'model' => $model,
                        'attribute' => 'newFieldProjects',
                        'data' => CHtml::listData(Project::model()->not_deleted()->findAll(), 'id', 'name', 'poject.name'),
                        //'data' => CHtml::listData(Project::model()->not_deleted()->findAll(!$model->id ? 'id != ' . $model->id : ''), 'id', 'title', 'collection.title'),
                    )); ?>
                    </div>
                    <?php echo $form->error($model, 'newFieldProjects'); ?>
                </div>

                <!-- Warning -->
                <div class="form-group">
                    <div class="no-label col-sm-9 col-md-9 col-lg-10">
                        <p class="note text-danger">Fields with <span class="required">*</span> are required.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-sm')); ?> or <a href="/cms/type/index" class="text-danger" href="#")>Cancel</a>
                </div>

            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
