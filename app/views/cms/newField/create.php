<?php
/* @var $this NewFieldController */
/* @var $model NewField */
/*
$this->breadcrumbs=array(
	'New Fields'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List NewField', 'url'=>array('index')),
	array('label'=>'Manage NewField', 'url'=>array('admin')),
);
*/
?>

<h1>Create NewField</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'tables'=>$tables)); ?>