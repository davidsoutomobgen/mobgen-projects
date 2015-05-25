<?php
/* @var $this NewFieldController */
/* @var $dataProvider CActiveDataProvider */
/*
$this->breadcrumbs=array(
	'New Fields',
);

$this->menu=array(
	array('label'=>'Create NewField', 'url'=>array('create')),
	array('label'=>'Manage NewField', 'url'=>array('admin')),
);
*/
?>

<h1>New Fields</h1>

<a href="/cms/newfield/create" class="btn btn-large" title="Add new type"><i class="fa fa-plus"></i></a>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

