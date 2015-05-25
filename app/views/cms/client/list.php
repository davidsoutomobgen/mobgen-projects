<div class="row">
    <div class="col-xs-12">
        <div id="client_list" class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-briefcase"></i></span>
                <h5>Client information</h5>
                <div class="buttons" style="z-index: 123">
                    <a href="/cms/client/create/<?php echo $model->id;?>" class="btn btn-large" title="Add new type">
                        <i class="fa fa-user-plus"></i>
                        <span>Client</span>
                    </a>
                </div>
            </div>
            <div class="widget-content">
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'client-grid',
                    'cssFile' => 'false',
                    'summaryText' => '', // '{start}-{end} to {count}',
                    'dataProvider' => $client->search(),
                    'filter' => $client,
                    'selectableRows'=>1,
                    'selectionChanged'=>'function(id){
                        location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);
                    }',
                    'columns' => array(
                        /*
                            array(
                            'header' => 'Image',
                            'type' => 'raw',
                            'value' => '!empty($data->logo) ? CHtml::image(Utils::imageUrl("..".DS."files".DS."types".DS.$data->logo), $data->name, array("width"=>45)) : CHtml::image(Utils::imageUrl("..".DS."files".DS."empty.png"), $data->name, array("width"=>45)) ',
                        ),
                        */
                        'name',
                        'email',
                        'job_title',
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
</div>

<script type="text/javascript">
$(document).ready( function() {
    $('#client_list .widget-title').click(function(){
        $('#client_list .widget-content').slideToggle('slow');
    });
});
</script>