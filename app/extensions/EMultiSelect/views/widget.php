<div class="ems-wrapper">
	<div class="ems-options">
		<div class="ems-search ems-search-available">
			<?php echo CHtml::label('Search', 'ems-search-field-available', array('class'=>'ems-search-label')); ?>
			<?php echo CHtml::textField('ems-search-field-available', '', array('class'=>'ems-search-field ems-search-field-available')); ?><br/>
		</div>
		<?php echo CHtml::listBox('ems-available-options', null, array(), array('class'=>'ems-available-options','size'=>10,'multiple'=>true)); ?>
	</div>
	<div class="ems-controls">
		<button type="button" class="ems-button ems-move-all-right">&raquo;</button>
		<button type="button" class="ems-button ems-move-sel-right">&rsaquo;</button>
		<button type="button" class="ems-button ems-move-sel-left">&lsaquo;</button>
		<button type="button" class="ems-button ems-move-all-left">&laquo;</button>
	</div>
	<div class="ems-options">
		<div class="ems-search ems-search-selected">
			<?php echo CHtml::label('Search', 'ems-search-field-selected', array('class'=>'ems-search-label')); ?>
			<?php echo CHtml::textField('ems-search-field-selected', '', array('class'=>'ems-search-field ems-search-field-selected')); ?><br/>
		</div>
		<?php echo CHtml::listBox('ems-selected-options', null, array(), array('class'=>'ems-selected-options','size'=>10,'multiple'=>true)); ?>
	</div>
</div>