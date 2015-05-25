<?php
/* @var $this TrackController */
/* @var $model Track */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript('gridImageSelection', "
	$('#Track_imageIds input').each(function(){
		checkChecked( $(this) );
	}).on('change', function() {
		checkChecked( $(this) );
	});
	function checkChecked( checkbox ) {
		if( checkbox.is(':checked') ) {
			checkbox.next().find('img').addClass('checked');
		} else {
			checkbox.next().find('img').removeClass('checked');
		}
		updateCount();
	}
	function updateCount() {
		$('#imageCount').text( $('#Track_imageIds input:checked').length );
	}
	$('#submitBtn').click(function() {
		$('.loading').show();
		var overlay = $('<div/>').addClass('overlay');
		$('body').prepend(overlay);
	});
");
Yii::app()->clientScript->registerCss('gridImageSelection', "
	#Track_imageIds input {
		display:none;
	}
	#Track_imageIds label {
		display:inline-block;
	}
	#Track_imageIds img {
		border:2px solid #999999;
		opacity:.6;
	}
	#Track_imageIds img.checked {
		border:2px solid #0d3a78;
		opacity:1;
	}
	.loading {
		background:url('/images/loader.gif') no-repeat left center;
		margin-left:10px;
		padding-left:20px;
		display:none;
	}
	.overlay {
		background: black url('/images/loading.gif') no-repeat center center;
		min-height: 1000px;
		height: 100%;
		position: absolute;
		width: 100%;
		z-index:99999;
		opacity:.4;
		overflow:hidden;
	}
");
?>

<h1><?php echo $model->isNewRecord ? 'Create' : 'Update'; ?> track</h1>

<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'track-form',
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="one_half">

		<div class="row">
			<?php echo $form->labelEx($model, 'title'); ?>
			<?php echo $form->textField($model, 'title', array('size' => 48, 'maxlength' => 255)); ?>
			<?php echo $form->error($model, 'title'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'version'); ?>
			<?php echo $form->textField($model, 'version', array('maxlength' => 255)); ?>
			<?php echo $form->error($model, 'version'); ?>
		</div>

	        <div class="row">
	            <?php echo $form->labelEx($model,'in_app'); ?>
	            <?php echo $form->dropDownList($model, 'in_app', $model->getType()); ?>
	            <?php echo $form->error($model,'in_app'); ?>
	        </div>

		<div class="row">
			<?php echo $form->labelEx($model, 'collection_id'); ?>
			<?php echo $form->dropDownList($model, 'collection_id', CHtml::listData(Collection::model()->findAll(), 'id', 'title')); ?>
			<?php echo $form->error($model, 'collection_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'mp3File'); ?>
			<?php echo $form->fileField($model, 'mp3File'); ?><br/>
			<?php if ($model->mp3) {
				echo "<small>Current file: " . CHtml::link($model->mp3, $model->trackUrl . $model->mp3, array('target' => '_blank')) . "</small>";
			} ?>
			<?php echo $form->error($model, 'mp3File'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'wavFile'); ?>
			<?php echo $form->fileField($model, 'wavFile'); ?><br/>
			<?php if ($model->wav) {
				echo "<small>Current file: " . CHtml::link($model->wav, $model->trackUrl . $model->wav, array('target' => '_blank')) . "</small>";
			} ?>
			<?php echo $form->error($model, 'wavFile'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'length_type'); ?>
			<?php echo $form->dropDownList($model, 'length_type', $model->getLengthTypes()); ?>
			<?php echo $form->error($model, 'length_type'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'bpm'); ?>
			<?php echo $form->numberField($model, 'bpm', array('size' => 4)); ?>
			<?php echo $form->error($model, 'bpm'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'probability'); ?>
			<?php echo $form->numberField($model, 'probability', array('min' => 0, 'max' => 100, 'size' => 4)); ?>
			<?php $this->widget('zii.widgets.jui.CJuiSlider', array(
				'value' => $model->probability ? : 10,
				'options' => array(
					'min' => 0,
					'max' => 100,
					'slide' => "js:function( event, ui ) {
						$('#Track_probability').val( ui.value );
					}",
				),
				'htmlOptions' => array(
					'style' => 'width:200px;margin-left:10px;display:inline-block;',
				),
			)); ?>
			<?php echo $form->error($model, 'probability'); ?>
		</div>

	</div>

	<div class="one_half last">

		<div class="row">
			<?php echo $form->labelEx($model, 'images'); ?>
			<?php echo $form->checkBoxList($model, 'imageIds', CHtml::listData(Image::model()->published()->findAll(), 'id', 'imagefile'), array('separator' => '')); ?>
			<p><small><strong><span id="imageCount">0</span></strong> image(s) selected</small></p>
			<?php echo $form->error($model, 'images'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'gradient_start'); ?>
			<?php $this->widget('ext.colorpicker.JColorPicker', array(
				'model' => $model,
				'attribute' => 'gradient_start',
				'options' => array(),
			)); ?>
			<?php echo $form->error($model, 'gradient_start'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'gradient_end'); ?>
			<?php $this->widget('ext.colorpicker.JColorPicker', array(
				'model' => $model,
				'attribute' => 'gradient_end',
			)); ?>
			<?php echo $form->error($model, 'gradient_end'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'relatedTracks'); ?>
			<?php $this->widget('ext.EMultiSelect.EMultiSelect', array(
				'model' => $model,
				'attribute' => 'relatedTracks',
				'data' => CHtml::listData(Track::model()->published()->findAll(!$model->isNewRecord ? 'id != ' . $model->id : ''), 'id', 'title', 'collection.title'),
			)); ?>
			<?php echo $form->error($model, 'relatedTracks'); ?>
		</div>

	</div>
	<div class="clear"></div>

	<div class="row">
		<?php echo $form->labelEx($model, 'about'); ?>
		<?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'about', 'options' => array(
			'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink | fontselect | fontsizeselect',
			'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-Light'),
			'style_formats' => Yii::app()->params['style_formats'],
			'formats' => Yii::app()->params['formats'],
		))); ?>
		<?php echo $form->error($model, 'about'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'lyrics'); ?>
		<?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'lyrics', 'options' => array(
			'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink | fontselect | fontsizeselect',
			'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-LightItalic'),
			'style_formats' => Yii::app()->params['style_formats'],
			'formats' => Yii::app()->params['formats'],
		))); ?>
		<?php echo $form->error($model, 'lyrics'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'notes'); ?>
		<?php $this->widget('ext.ETinyMCE.ETinyMCE', array('model' => $model, 'attribute' => 'notes', 'options' => array(
			'toolbar' => 'undo redo | formatselect styleselect | underline strikethrough | bullist numlist outdent indent | link unlink | fontselect | fontsizeselect',
			'forced_root_block_attrs' => array('style' => 'font-family: HelveticaNeue-Light'),
			'style_formats' => Yii::app()->params['style_formats'],
			'formats' => Yii::app()->params['formats'],
		))); ?>
		<?php echo $form->error($model, 'notes'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('id' => 'submitBtn', 'class' => 'button')); ?>
		<span class="loading">Loading...</span>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->