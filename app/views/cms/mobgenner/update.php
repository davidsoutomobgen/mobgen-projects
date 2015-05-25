<?php
/* @var $this MobgennerController */
/* @var $model Mobgenner */
?>
<div id="content-header" class="mini" style="display: block;">
    <h1>Update mobgenner</h1>
</div>

<div id="breadcrumb">
    <a href="/site" title="Dashboard" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/cms/type/index" title="Project type" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-circle-o"></i> Mobgenners</a>
    <a href="/cms/type/update/<?php echo $model->id; ?>" class="current">Edit mobgenner</a>

</div>

<?php $this->renderPartial('_form', array('model'=>$model, 'user'=>$user)); ?>