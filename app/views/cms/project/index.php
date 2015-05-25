<div id="content-header" class="mini">
    <h1>Projects</h1>
    <div class="btn-group">
        <a href="/cms/project/create" class="btn btn-large" title="Add new Project"><i class="fa fa-plus"></i></a>
    </div>
</div>

<div id="breadcrumb">
    <a href="/site" title="Dashboard" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/cms/project/index" class="current">Projects</a>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-th"></i></span>
                <h5>Projects</h5>
            </div>
            <div class="widget-content nopadding">

                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'project-grid',
                    'cssFile' => 'false',
                    'summaryText' => '{start}-{end} to {count}',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'selectableRows'=>1,
                    'selectionChanged'=>'function(id){
                        location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);
                    }',
                    'columns' => array(
                        array(
                            'header' => 'Logo',
                            'type' => 'raw',
                            'value' => '!empty($data->logo) ? CHtml::image(Utils::imageUrl("..".DS."files".DS."projects".DS.$data->logo), $data->name, array("width"=>45)) : CHtml::image(Utils::imageUrl("..".DS."files".DS."empty.png"), $data->name, array("width"=>45)) ',
                        ),
                        'name',
                        'alias',
                        'description',
                        array(
                            'name' => 'date_created',
                            'value' => 'Utils::date($data->date_created)',
                        ),
                        array(
                            'name' => 'date_updated',
                            'value' => '$data->date_updated != $data->date_created ? Utils::date($data->date_updated) : "never"',
                        ),
                        array(
                            'header' => 'Actions',
                            'class' => 'CButtonColumn',
                            'template' => '{view}{update}{delete}',
                            'buttons' => array(
                                'view' => array(
                                    'imageUrl'=>_bu('/images/view.png'),
                                ),
                                'update' => array(
                                    'imageUrl'=>_bu('/images/update.png'),
                                ),
                                'delete' => array(
                                    'imageUrl'=>_bu('/images/delete.png'),
                                ),
                            ),
                        ),
                    ),
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                        'firstPageLabel' => 'First',
                        'prevPageLabel' => 'Previous',
                        'nextPageLabel' => 'Next',
                        'lastPageLabel' => 'Last',
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div id="content-footer" class="mini">
        <div class="btn-group">
            <a href="/cms/project/create" class="btn btn-large" title="Add new Project"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</div>
