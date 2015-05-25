<div id="content-header" class="mini" style="display: block;">
    <h1>Update type "<?php echo $model->name; ?>"</h1>
</div>

<div id="breadcrumb">
    <a href="/site" title="Dashboard" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/cms/type/index" title="Project type" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-desktop"></i> Project type</a>
    <a href="/cms/type/create" class="current">Update type</a>
</div>

<?php
/* @var $this TypeController */
/* @var $model Type */

/*
$this->breadcrumbs=array(
	'Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Type', 'url'=>array('index')),
	array('label'=>'Create Type', 'url'=>array('create')),
	array('label'=>'View Type', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Type', 'url'=>array('admin')),
);
*/
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>