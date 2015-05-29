<div id="content-header" class="mini">
    <h1>Dashboard</h1>
</div>

<div class="dashboard">
        <?php
            $this->widget('zii.widgets.CMenu', array(
                'id' => 'dashboard',
                'items' => array(
                    array(
                        'label' => 'Projects',
                        'url' => array('cms/project/index'),
                        'linkOptions' => array(
                            'style' => 'background-image:url("/images/projects.png");'
                        ),
                    ),

                    array(
                        'label' => 'Projects Type',
                        'url' => array('cms/type/index'),
                        'linkOptions' => array(
                            'style' => 'background-image:url("/images/projects-type.png");'
                        ),
                    ),

                    array(
                        'label' => 'Mobgenners',
                        'url' => array('cms/mobgenner/index'),
                        'linkOptions' => array(
                            'style' => 'background-image:url("/images/mobgen_circle.png");'
                        ),
                    ),
                ),
            ));
        ?>
</div>