<?php $this->widget('zii.widgets.CMenu', array(
    'items' => array(
        array('label' => '<i class="fa fa-home"></i> <span>Dashboard</span></a>', 'url' => array('/cms/index')),
        array('label' => '<i class="fa fa-flask"></i> <span>Projects</span>', 'url' => array('/cms/project/index')),
        array('label' => '<i class="fa fa-desktop"></i> <span>Projects type</span>', 'url' => array('/cms/type/index')),
        array('label' => '<i class="fa fa-circle-o"></i> <span>Mobgenners</span>', 'url' => array('/cms/mobgenner/index')),
        array(
            'label' => '<i class="fa fa-cog"></i> <span>Administrator</span> <i class="arrow fa fa-chevron-right"></i>',
            'url' => '/admin/index',
            'linkOptions'=> array(
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
            ),
            'itemOptions' => array('class'=>'dropdown user'),
            'items' => array(
                array(
                    'label' => '<i class="fa fa-indent"></i><span>New fields</span>',
                    'url' => '/cms/newfield',
                ),
                array(
                    'label' => '<i class="fa fa-file-archive-o"></i><span>View logs</span>',
                    'url' => '/admin/logs',
                ),
                array(
                    'label' => '<i class="fa fa-file-code-o"></i><span>System settings</span>',
                    'url' => '/admin/system',
                ),
                array(
                    'label' => '<i class="fa fa-users"></i><span>Users</span>',
                    'url' => '/admin/users',
                ),
            )
        ),
    ),
    'encodeLabel' => false,
    'htmlOptions' => array(
        'class'=>'nav pull-right',
    ),
    /*
    'submenuHtmlOptions' => array(
        'class' => 'dropdown-menu',
    )
    */
));?>