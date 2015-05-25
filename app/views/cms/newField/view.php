<?php
/* @var $this NewFieldController */
/* @var $model NewField */
/*
$this->breadcrumbs=array(
	'New Fields'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List NewField', 'url'=>array('index')),
	array('label'=>'Create NewField', 'url'=>array('create')),
	array('label'=>'Update NewField', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NewField', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NewField', 'url'=>array('admin')),
);*/
?>

<h1>View NewField #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'label',
		'type_field',
		'table',
		'position',
		'date_created',
		'date_updated',
		'deleted',
	),
)); ?>
