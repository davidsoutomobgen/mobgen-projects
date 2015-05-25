<?php
/* @var $this SiteController */
?>

<h1>Dashboard</h1>

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
            /*
		array(
			'label' => 'Projects Type',
			'url' => array('cms/type/index'),
			'linkOptions' => array(
				'style' => 'background-image:url("/images/modifier.png");'
			),
		),
        */
	),
));