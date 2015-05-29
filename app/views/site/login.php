
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-lock"></i></span>
                <h5>Login</h5>
            </div>
            <div class="widget-content ">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array(
                        'autocomplete' => 'off',
                        'class'=>'form-horizontal',

                    ),
                        ));
                ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Username', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->textField($model, 'username'); ?>
                    </div>
                    <?php echo $form->error($model, 'username'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'Password', array('class' => 'col-sm-3 col-md-3 col-lg-2 control-label')); ?>
                    <div class="col-sm-9 col-md-9 col-lg-10">
                        <?php echo $form->passwordField($model, 'password'); ?>
                    </div>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
<!--
                <div class="row rememberMe">
                    <?php echo $form->label($model, 'RememberMe'); ?>
                    <?php echo $form->checkBox($model, 'rememberMe'); ?>
                    <?php echo $form->error($model, 'rememberMe'); ?>
                </div>
-->
                <div class="form-actions">
                    <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary btn-sm')); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>