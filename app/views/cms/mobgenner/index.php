<div id="content-header" class="mini">
    <h1>Mobgenners</h1>
    <div class="btn-group">
        <a href="/cms/mobgenner/create" class="btn btn-large" title="Add new type"><i class="fa fa-plus"></i></a>
    </div>
</div>

<div id="breadcrumb">
    <a href="/site" title="Dashboard" class="tip-bottom" data-original-title="Go to Home"><i class="fa fa-home"></i> Dashboard</a>
    <a href="/cms/type/index" class="current">Mobgenners</a>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-th"></i></span>
                <h5>List</h5>
            </div>
            <div class="widget-content nopadding">

                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'type-grid',
                    'cssFile' => 'false',
                    'summaryText' => '{start}-{end} to {count}',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'rowCssClassExpression' => '
                        ( $row%2 ? $this->rowCssClass[1] : $this->rowCssClass[0] ) .
                        ( $data->active ? null : " disabled" )
                    ',
                    'selectableRows'=>1,
                    'selectionChanged'=>'function(id){
                        location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);
                    }',
                    'columns' => array(
                        array(
                            'header' => '',
                            'type' => 'raw',
                            'value' => '!empty($data->image) ? CHtml::image(Utils::imageUrl("..".DS."files".DS."mobgenners".DS.$data->image), $data->name, array("width"=>45)) : (!empty($data->active) ? CHtml::image(Utils::imageUrl("user-128_mobgen.png"), $data->name, array("width"=>45)) : CHtml::image(Utils::imageUrl("user-128_mobgen_off.png"), $data->name, array("width"=>45))) ',
                            'htmlOptions'=>array('width'=>'40px'),
                        ),
                        'name',
                        'email',
                        'skype',
                        'job_title',
                        array(
                            'header' => 'Active',
                            'htmlOptions'=>array('width'=>'40px'),
                            'value' => 'Mobgenner::getActiveText($data->active)',
                            'filter'=>array('1'=>'On','0'=>'Off'),
                            //'filter'=> Mobgenner::getActive(),
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
            <a href="/cms/mobgenner/create" class="btn btn-large" title="Add new type"><i class="fa fa-plus"></i></a>
        </div>
    </div>
</div>
