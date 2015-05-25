<?php
/* @var $this ProjectController */
/* @var $model Project */
?>

<div class="row">
    <div class="col-xs-12">
        <div id="project_view" class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-eye"></i></span>
                <h5>General information</h5>
                <div class="buttons">
                    <?php
                    $this->widget('ext.mPrint.mPrint', array(
                        'title' => 'User Result',        //the title of the document. Defaults to the HTML title
                        'tooltip' => 'User Result',    //tooltip message of the print icon. Defaults to 'print'
                        'text' => '<span class="text">Print</span>', //text which will appear beside the print icon. Defaults to NULL
                        'element' => '#content_type',      //the element to be printed.
                        'exceptions' => array(     //the element/s which will be ignored
                            '.summary',
                            '.search-form'
                        ),
                        'publishCss' => true,       //publish the CSS for the whole page?
                        'id' => 'resultprintid',
                    ));
                    ?>
                </div>
            </div>

            <div id="content_type" class="widget-content">
                <div class="invoice-content">
                    <div class="invoice-head">
                        <div class="invoice-meta width_50 left">
                            Name: <span class="invoice-number"><?php echo $model->name; ?></span>
                        </div>
                        <div class="dates-meta width_50 right">
                            <p class="invoice-date clear">Created: <?php echo date('Y-m-d', $model->date_created); ?></p>
                            <p class="invoice-date clear">Updated: <?php echo date('Y-m-d', $model->date_updated); ?></p>
                        </div>
                        <div class="clear">
                            <div class="invoice-from">
                                <ul>
                                    <li>
                                        <span><strong>Alias</strong></span>
                                        <span><?php echo $model->alias; ?></span>
                                    </li>
                                    <li>
                                        <span><strong>Description</strong></span>
                                        <span><?php echo $model->description; ?></span>
                                    </li>
                                    <li>
                                        <span><strong>Additional information</strong></span>
                                        <span><?php echo $model->additional_information; ?></span>
                                    </li>
                                    <li>
                                        <span><strong>Onboarding document</strong></span>
                                        <a href='<?php echo $model->onboarding_document;?>' ><?php echo $model->onboarding_document; ?></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="invoice-to">
                                <ul>
                                    <li>
                                        <span><strong>Logo</strong></span>
                                        <span>
                                        <?php
                                        if ($model->logo) {
                                            echo CHtml::image(Utils::imageUrl('..'.DS.'files'.DS.'projects'.DS.$model->logo), '', array('style'=>'width:48px; margin:10px 0 5px;'));
                                        }
                                        ?>
                                        </span>
                                    </li>
                                    <li>
                                        <span><strong>Active</strong></span>
                                        <span><?php echo $model->active; ?></span>
                                    </li>
                                    <li>
                                        <span><strong>Internal</strong></span>
                                        <span><?php echo $model->internal; ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready( function() {
        $('#project_view .widget-title').click(function(){
            $('#project_view .widget-content').slideToggle('slow');
        });
    });
</script>
