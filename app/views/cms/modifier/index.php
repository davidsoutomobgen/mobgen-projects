<?php
/* @var $this ModifierController */
/* @var $model Modifier */
?>

<h1>Modifiers</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'modifier-grid',
	'cssFile' => 'false',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){
		location.href = "'.$this->createUrl('update').'/id/"+$.fn.yiiGridView.getSelection(id);
	}',
	'columns' => array(
		'description',
		'value',
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}',
			'buttons' => array(
				'update' => array(
					'imageUrl'=>_bu('/images/update.png'),
				),
				'delete' => array(
					'imageUrl'=>_bu('/images/delete.png'),
				),
			),
		),
	),
	'pager' => array(
		'cssFile' => false,
		'header' => '',
		'firstPageLabel' => '&laquo;',
		'prevPageLabel' => '&lsaquo;',
		'nextPageLabel' => '&rsaquo;',
		'lastPageLabel' => '&raquo;',
	),
));