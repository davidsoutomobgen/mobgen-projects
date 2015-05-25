<?php
/* @var $this ProjectController */
/* @var $model Project */
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
                    'id'=>'project-form',
                    'enableAjaxValidation'=>false,
                    'htmlOptions'=>array(
                        'class'=>'form-horizontal',
                        'enctype' => 'multipart/form-data'
                    ),
                )); ?>

                <?php echo $form->errorSummary($model); ?>
                <!-- Name -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'name', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'name',array('class' => 'form-control input-sm', 'placeholder' => 'Name', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'name'); ?>
                </div>
                <!-- Alias -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'alias', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'alias',array('class' => 'form-control input-sm', 'placeholder' => 'Alias', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'alias'); ?>
                </div>
                <!-- Description -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'description', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'description',array('class' => 'form-control input-sm', 'placeholder' => 'Description', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'description'); ?>
                </div>
                <!-- Logo -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'logo', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->fileField($model, 'logo'); ?>
                    </div>
                    <?php echo $form->error($model,'logo'); ?>
                    <?php
                    if ($model->logo) {
                        echo $form->hiddenField($model,'logo',array('value'=>$model->logo));
                        echo '<div class="col-sm-9 col-md-9 col-lg-10">';
                        echo CHtml::image(Utils::imageUrl('..' . DS . 'files' . DS . 'projects' . DS . $model->logo), '', array('style'=>'width:48px; margin:10px 0 5px;'));
                        echo '</div>';
                    }
                    ?>
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
                    <input type="radio" id="active1" name="Project[active]" value="1" <?php echo !empty($model->active) ? 'checked="checked"' : '' ?> /><label for="active1">On</label>
                    <input type="radio" id="active2" name="Project[active]" value="0" <?php echo empty($model->active) ? 'checked="checked"' : '' ?> /><label for="active2">Off</label>

                    <?php $this->endWidget();?>
                </div>

                <!-- Internal -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'internal', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <?php $radio = $this->beginWidget('zii.widgets.jui.CJuiButton', array(
                        'name'=>'btnradio',
                        'buttonType'=>'buttonset',
                        'htmlOptions'=>array('class'=>'col-sm-9 col-md-9 col-lg-9')
                    )); ?>
                    <input type="radio" id="internal1" name="Project[internal]" value="1" <?php echo !empty($model->internal) ? 'checked="checked"' : '' ?> /><label for="internal1">On</label>
                    <input type="radio" id="internal2" name="Project[internal]" value="0" <?php echo empty($model->internal) ? 'checked="checked"' : '' ?> /><label for="internal2">Off</label>

                    <?php $this->endWidget();?>
                </div>
                <!-- Project type -->
                <div id="div_project_type" class="form-group">
                    <?php echo $form->labelEx($model,'Project type', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <?php $radio = $this->beginWidget('zii.widgets.jui.CJuiButton', array(
                        'name'=>'btnradio',
                        'buttonType'=>'buttonset',
                        'htmlOptions'=>array('class'=>'col-sm-9 col-md-9 col-lg-9')
                    )); ?>
                    <?php
                    $types = Type::model()->findAll(array('order'=>'name'));
                    foreach ($types as $t) {
                        $checked = '';
                        if (in_array($t->id, $project_types))
                            $checked = 'checked="checked"';

                        if (!empty($t->logo))
                            echo ' <input type="checkbox" name="Project[projectType][]" value="'.$t->id.'" id="check'.$t->id.'" '.$checked.' /><label for="check'.$t->id.'"><img src="/files/types/'.$t->logo.'" title="'.$t->name.'" /></label>';
                        else
                            echo ' <input type="checkbox" name="Project[projectType][]" value="'.$t->id.'" id="check'.$t->id.'" '.$checked.' /><label for="check'.$t->id.'">'.$t->name.'</label>';

                    }
                    ?>
                    <?php $this->endWidget();?>
                </div>
                <!-- Additional information -->
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'additional_information', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'additional_information', 'options' => array(
                            'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink',
                            'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-Light'),
                            'style_formats' => Yii::app()->params['style_formats'],
                            'formats' => Yii::app()->params['formats'],
                        ))); ?>
                    </div>
                    <?php echo $form->error($model, 'additional_information'); ?>
                </div>
                <!-- Onboarding document -->
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'onboarding_document', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'onboarding_document', 'options' => array(
                            'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink',
                            'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-Light'),
                            'style_formats' => Yii::app()->params['style_formats'],
                            'formats' => Yii::app()->params['formats'],
                        )));?>
                    </div>
                    <?php echo $form->error($model, 'onboarding_document'); ?>
                </div>
                <!-- NEW FIELDS -->
                <?php
                //var_dump($new_field);die;
                if (!empty($new_field)){
                    foreach ($new_field[0] as $field) {
                        $f = $field->attributes;
                        //var_dump($f);die;
                        echo '<div class="form-group">';
                            echo $form->labelEx($model, $f['label'], array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label'));
                            echo '<div class="col-sm-9 col-md-9 col-lg-10">';
                            $type = $model->getTypeField();
                            $content = NewFieldValues::model()->findAllByAttributes(array('new_field'=>$f['id'], 'view_id'=>$model->id));
                            if (!empty($content[0]->value)) $value=$content[0]->value;
                            else $value='';
                            echo '<input type="'.$type[$f['type_field']].'" name="NewField['.$f['id'].']" id="'.$f['id'].'" class="form-control input-sm" placeholder="'.$f['label'].'" value="'.$value.'" />';
                            echo '</div>';
                            echo $form->error($model, $f['label']);
                        echo '</div>';
                    }
                }
                ?>

                <!-- Warning -->
                <div class="form-group">
                    <div class="no-label col-sm-9 col-md-9 col-lg-10">
                        <p class="note text-danger">Fields with <span class="required">*</span> are required.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-sm')); ?> or <a href="/cms/project/index" class="text-danger" href="#">Cancel</a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
