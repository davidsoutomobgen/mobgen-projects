<div id="content-header" class="mini" style="display: block;">
    <h1>Update Field: "<?php echo $model->name;?>"</h1>
</div>

<div id="breadcrumb">
    <a href="/site" title="Dashboard" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/cms/newField/index" title="Project type" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-indent"></i> New Field</a>
    <a href="/cms/newField/update/<?php echo $model->id;?>" class="current">Update field</a>
</div>

<?php $this->renderPartial('_form', array('model'=>$model, 'tables'=>$tables)); ?>