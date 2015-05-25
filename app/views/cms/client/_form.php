<?php
/* @var $this ClientController */
/* @var $model Client */
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
                    'id'=>'client-form',
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
                <?php echo $form->hiddenField($model,'id_project',array('type'=>"hidden",'value'=>$model->id_project)); ?>
                <!-- Name -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'name', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'name',array('class' => 'form-control input-sm', 'placeholder' => 'Name', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'name'); ?>
                </div>
                <!-- Email -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'email', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'email',array('class' => 'form-control input-sm', 'placeholder' => 'email', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'email'); ?>
                </div>
                <!-- Phone -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'phone', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'phone',array('class' => 'form-control input-sm', 'placeholder' => 'Phone', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'phone'); ?>
                </div>
                <!-- Company -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'company', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'company',array('class' => 'form-control input-sm', 'placeholder' => 'Company', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'company'); ?>
                </div>
                <!-- Job title-->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'job_title', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'job_title',array('class' => 'form-control input-sm', 'placeholder' => 'Job title', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'job_title'); ?>
                </div>

                <!-- Image -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'image', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->fileField($model, 'image'); ?>
                    </div>
                    <?php echo $form->error($model,'image'); ?>
                    <span class="row">
                    <?php
                    if ($model->image) {
                        echo $form->hiddenField($model,'image',array('value'=>$model->image));
                        echo '<div class="col-sm-9 col-md-9 col-lg-10">';
                        echo CHtml::image(Utils::imageUrl('..' . DS . 'files' . DS . 'client' . DS . $model->image), '', array('style'=>'margin:10px 0 5px;'));
                        echo '</div>';
                    }
                    ?>
                </span>
                </div>

                <!-- Active -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'active', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <?php $radio = $this->beginWidget('zii.widgets.jui.CJuiButton', array(
                        'name'=>'btnradio',
                        'buttonType'=>'buttonset',
                        'htmlOptions'=>array('class'=>'col-sm-9 col-md-9 col-lg-9')
                    ));
                    ?>
                    <input type="radio" id="active1" name="Client[active]" value="1" <?php echo !empty($model->active) ? 'checked="checked"' : '' ?> /><label for="active1">On</label>
                    <input type="radio" id="active2" name="Client[active]" value="0" <?php echo empty($model->active) ? 'checked="checked"' : '' ?> /><label for="active2">Off</label>

                    <?php $this->endWidget();?>
                </div>

                <div class="form-group">
                    <div class="no-label col-sm-9 col-md-9 col-lg-10">
                        <p class="note text-danger">Fields with <span class="required">*</span> are required.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-sm')); ?> or <a href="/cms/project/view/<?php echo $model->id_project;?>" class="text-danger" href="#">Cancel</a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>


