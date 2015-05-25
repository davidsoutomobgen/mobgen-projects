<div id="content-header" class="mini" style="display: block;">
    <h1>Create Project</h1>
</div>

<div id="breadcrumb">
    <a href="/site" title="Dashboard" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/cms/project/index" title="Project type" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-desktop"></i> Projects</a>
    <a href="/cms/project/create" class="current">Create new Project</a>

</div>

<?php $this->renderPartial('_form', array('model'=>$model, 'project_types'=>$project_types, 'new_field'=>$new_field)); ?>