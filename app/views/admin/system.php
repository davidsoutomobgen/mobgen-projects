<h2>System settings</h2>
<div class='form one_half'>
    <fieldset>
        <legend>Settings</legend>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'system-form',
            'enableClientValidation' => true,
                ));
        ?>
        <?php echo $form->errorSummary($system); ?>

        <div class="row">
            <?php echo $form->labelEx($system, 'min_app_version'); ?>
            <?php echo $form->textField($system, 'min_app_version'); ?>
            <?php echo $form->error($system, 'min_app_version'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($system, 'build_url'); ?>
            <?php echo $form->textField($system, 'build_url', array('size' => '60')); ?>
            <?php echo $form->error($system, 'build_url'); ?>
        </div>
        
    </fieldset>
</div>
<div class="clear"></div>

<?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>

<?php
$this->endWidget('CActiveForm');
?>
