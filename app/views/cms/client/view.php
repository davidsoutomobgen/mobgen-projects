<?php
/* @var $this ClientController */
/* @var $model Client */
/*
$this->breadcrumbs=array(
	'Clients'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Client', 'url'=>array('index')),
	array('label'=>'Create Client', 'url'=>array('create')),
	array('label'=>'Update Client', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Client', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Client', 'url'=>array('admin')),
);
*/
?>

<h1>View Client #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_project',
		'name',
		'email',
		'phone',
		'company',
		'job_title',
		'image',
		'active',
		'user',
		'date_created',
		'date_updated',
		'deleted',
	),
)); ?>
