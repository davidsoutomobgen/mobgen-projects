
<div id="content-header">
    <h1>Project: "<?php echo $model->name; ?>"</h1>
    <div class="btn-group">
        <a title="Manage Files" class="btn"><i class="fa fa-edit"></i></a>
        <a title="Manage Users" class="btn"><i class="fa fa-trash-o"></i></a>
        <a href="/cms/projects/index" title="Go Project Types" class="btn"><i class="fa fa-level-up"></i></a>
    </div>
</div>

<div id="breadcrumb">
    <a class="tip-bottom" title="" href="#" data-original-title="Go to Home"><i class="fa fa-home"></i> Home</a>
    <a href="/cms/project/index">Projects</a>
    <a class="current" href="/cms/project/view/<?php echo $model->id; ?>">View Project</a>
</div>

<?php $this->renderPartial('view', array('model'=>$model, 'new_field'=>$new_field)); ?>

<?php $this->renderPartial('../client/list', array('model'=>$model, 'client'=>$client)); ?>
