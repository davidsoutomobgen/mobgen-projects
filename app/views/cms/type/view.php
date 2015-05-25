
<?php
/* @var $this TypeController */
/* @var $model Type */
?>


<div id="content-header">
    <h1>Type: "<?php echo $model->name; ?>"</h1>
    <div class="btn-group">
        <a title="Manage Files" class="btn"><i class="fa fa-edit"></i></a>
        <a title="Manage Users" class="btn"><i class="fa fa-trash-o"></i></a>
        <a href="/cms/type/index" title="Go Project Types" class="btn"><i class="fa fa-level-up"></i></a>
    </div>
</div>

<div id="breadcrumb">
    <a class="tip-bottom" title="" href="#" data-original-title="Go to Home"><i class="fa fa-home"></i> Home</a>
    <a href="/cms/type/index">Project type</a>
    <a class="current" href="/cms/type/view/<?php echo $model->id; ?>">View Project type</a>
</div>

    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-title">
				    <span class="icon"><i class="fa fa-eye"></i></span>
                    <h5>View</h5>
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
                                            <span><strong>Description</strong></span>
                                            <span><?php echo $model->description; ?></span>
                                        </li>
                                    </ul>
                            </div>
                                <div class="invoice-to">
                                    <ul>
                                        <li>
                                            <span>
                                            <?php
                                                if ($model->logo) {
                                                    echo CHtml::image(Utils::imageUrl('..'.DS.'files'.DS.'types' . DS . $model->logo), '', array('style'=>'margin:10px 0 5px;'));
                                                }
                                            ?>
                                            </span>
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


