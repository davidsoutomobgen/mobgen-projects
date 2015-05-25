<?php
/* @var $this MobgennerController */
/* @var $model Mobgenner */
/*
$this->breadcrumbs=array(
	'Mobgenners'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Mobgenner', 'url'=>array('index')),
	array('label'=>'Create Mobgenner', 'url'=>array('create')),
	array('label'=>'Update Mobgenner', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mobgenner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mobgenner', 'url'=>array('admin')),
);
*/
?>

<h1>View Mobgenner #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_project',
		'name',
		'email',
		'phone',
		'skype',
		'job_title',
		'image',
		'active',
		'user',
		'date_created',
		'date_updated',
		'deleted',
	),
)); ?>
