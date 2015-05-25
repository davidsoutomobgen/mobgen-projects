<?php
//Configuration for the Rest Resources

return array(
	'project, projects' => array( //case insensitive
		'allow', //allow as default (or "deny")
		'class' => 'Project', //case sensitive
		'actions' => array(
			'list',
			'view',
		),
	),
);
