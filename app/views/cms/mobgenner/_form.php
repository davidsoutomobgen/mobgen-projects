<?php
/* @var $this MobgennerController */
/* @var $model Mobgenner */
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
                    'id'=>'mobgenner-form',
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
                <!-- skype -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'skype', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model,'skype',array('class' => 'form-control input-sm', 'placeholder' => 'skype', 'size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php echo $form->error($model,'skype'); ?>
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
                        echo CHtml::image(Utils::imageUrl('..' . DS . 'files' . DS . 'mobgenners' . DS . $model->image), '', array('style'=>'margin:10px 0 5px;'));
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
                    <input type="radio" id="active1" name="Mobgenner[active]" value="1" <?php echo !empty($model->active) ? 'checked="checked"' : '' ?> /><label for="active1">On</label>
                    <input type="radio" id="active2" name="Mobgenner[active]" value="0" <?php echo empty($model->active) ? 'checked="checked"' : '' ?> /><label for="active2">Off</label>

                    <?php $this->endWidget();?>
                </div>


                <!-- User -->
                <div class="form-group">
                    <?php echo $form->labelEx($model,'Create user', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <?php $radio = $this->beginWidget('zii.widgets.jui.CJuiButton', array(
                        'name'=>'btnradio',
                        'buttonType'=>'buttonset',
                        'htmlOptions'=>array('class'=>'col-sm-9 col-md-9 col-lg-9')
                    ));
                    ?>
                    <input type="radio" id="user1" name="Mobgenner[user]" value="<?php echo $model->user?>" <?php echo !empty($model->user) ? 'checked="checked"' : '' ?> /><label for="user1">On</label>
                    <input type="radio" id="user2" name="Mobgenner[user]" value="0" <?php echo empty($model->user) ? 'checked="checked"' : '' ?> /><label for="user2">Off</label>

                    <?php $this->endWidget();?>
                    <div id="div_user_type" class="clear"  <?php echo empty($model->user) ? 'style="display:none"' : '' ?> >
                    <label class="col-sm-3 col-md-3 col-lg-2 control-label" for="profiles">Profiles</label>
                    <div class="col-sm-9 col-md-9 col-lg-9" >
                        <?php
                        $roles = Role::getRoles();
                        foreach ($roles as $k => $rol) {
                            if ($rol == 'Admin') {
                                //var_dump($user);die;
                                $checked = '';
                                $visible = '';
                                if ($user->role == 9)
                                    $checked = 'checked="checked"';
                                else
                                    $visible = 'style="display:none"';

                                echo '<input type="checkbox" id="'.$rol.'" name="Mobgenner[role]['.$rol.']" value="'.$k.'" '.$checked.'/> '.Role::toText($k);
                                echo ' <small> ('.Role::explainRole($k).')</small><br />';

                                echo '<div id="div_'.$rol.'" '.$visible.'>';
                                    echo '<input type="radio" id="allprojects_'.$rol.'" name="all_projects_'.$rol.'" value="0" ' . $checked . ' />All projects';
                                echo '</div>';

                                echo '</div><div class="clear"></div>';
                            }
                            else {
                                //var_dump($rol);
                                $checked = '';
                                $class = 'class="roles"';
                                echo '<input type="checkbox" id="'.$rol.'" name="Mobgenner[role]['.$rol.']" value="'.$k.'" '.$class.'  /> '.Role::toText($k);

                                echo ' <small> ('.Role::explainRole($k).')</small><br />';
                                echo '<div id="div_'.$rol.'" style="display:none">';
                                    echo '<input type="radio" id="allprojects_'.$rol.'" name="all_projects_'.$rol.'" value="0" ' . $checked . ' />All projects<br />';
                                    if ($rol != 'Admin')
                                        echo '<input type="radio" id="specific_'.$rol.'" name="all_projects_'.$rol.'" value="1"/>Specific projects<br />';
                                    if ($rol=='User' || $rol == 'Client') {
                                        echo '<div id="projects_'.$rol.'" style="display:none">';
                                        $this->widget('ext.EMultiSelect.EMultiSelect', array(
                                            'model' => $model,
                                            'attribute' => 'user_type_'.$rol,
                                            'data' => CHtml::listData(Project::model()->not_deleted()->findAll(), 'id', 'name', 'project.name'),
                                        ));
                                        echo '</div>';
                                    }
                                echo '</div><div class="clear"></div>';
                            }
                        }
                        ?>
                    </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="no-label col-sm-9 col-md-9 col-lg-10">
                        <p class="note text-danger">Fields with <span class="required">*</span> are required.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-sm')); ?> or <a href="/cms/mobgenner/index" class="text-danger" href="#">Cancel</a>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready( function() {
        $('#user1').click(function(){
            $('#div_user_type').slideToggle('slow');
        });
        $('#User').click(function(){
            $('#div_User').slideToggle('slow');
        });
        $('#specific_User').click(function(){
            $('#projects_User').slideToggle('slow');
        });
        $('#Client').click(function(){
            $('#div_Client').slideToggle('slow');
        });
        $('#specific_Client').click(function(){
            $('#projects_Client').slideToggle('slow');
        });
        $('#Dev').click(function(){
            $('#div_Dev').slideToggle('slow');
        });
        $('#Admin').click(function(){
            $('#div_Admin').slideToggle('slow');
            if ($('#Admin').is(':checked'))
                $("input.roles").attr("disabled", true);
            else
                $("input.roles").removeAttr("disabled");

        });
        /*
        $(input:radio').click(function() {
            alert('aki');
            if ($(this).val() === '1') {
                myFunction();
            } else if ($(this).val() === '2') {
                myOtherFunction();
            }
        });
        */
    });
</script>

