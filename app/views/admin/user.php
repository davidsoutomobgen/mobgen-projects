<h2>Add/Edit user</h2>
<div class='form one_half'>
    <fieldset>
        <legend>Details:</legend>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'system-user-form',
            'enableClientValidation' => true,
                ));
        ?>

        <?php echo $form->errorSummary($user); ?>

        <div class="row">
            <?php echo $form->labelEx($user, 'username'); ?>
            <?php echo $form->textField($user, 'username'); ?>
            <?php echo $form->error($user, 'username'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($user, 'password'); ?>
            <?php echo $form->passwordField($user, 'password', array('value' => '')); ?>
            <?php echo $form->error($user, 'password'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($user, 'role'); ?>
            <?php echo $form->dropDownList($user, 'role', Role::getRoles()); ?>
            <?php echo $form->error($user, 'role'); ?>
        </div>

    </fieldset>
</div>
<div class="clear"></div>

<?php echo CHtml::submitButton('Save', array('class' => 'button')); ?> or <?php echo CHtml::link('cancel', _url('admin/users')); ?>

<?php
$this->endWidget('CActiveForm');
?>
</div>