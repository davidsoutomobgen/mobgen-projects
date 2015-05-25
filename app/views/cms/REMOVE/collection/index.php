<?php
/* @var $this CollectionController */
/* @var $model Collection */
?>

<h1>Collections</h1>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'collection-grid',
	'cssFile' => 'false',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){
		location.href = "'.$this->createUrl('update').'/id/"+$.fn.yiiGridView.getSelection(id);
	}',
	'columns' => array(
		'title',
		array(
			'name' => 'price_type',
			'value' => '$data->getPriceTypeText($data->price_type)',
		),
		array(
			'class' => 'CButtonColumn',
			'template' => '{update}{delete}',
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

echo CHtml::link('Add collection', array('cms/collection/create'), array('class'=>'button'));