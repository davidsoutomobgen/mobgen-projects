<?php
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans&subset=latin' rel='stylesheet' type='text/css'>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/favicon/mobgen_logo_32.png">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/images/favicon/favicon_57x57.png">

    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/favicon_72x72.png">

    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/favicon_114x114.png">

    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/favicon_144x144.png">

    <?php Utils::registerCssFile('main'); ?>
	<?php Utils::registerCssFile('form'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/mobgen/bootstrap.min.css">
    <link rel="stylesheet" href="/css/mobgen/font-awesome.css">
    <link rel="stylesheet" href="/css/mobgen/fullcalendar.css">
    <link rel="stylesheet" href="/css/mobgen/jquery.jscrollpane.css">
    <link rel="stylesheet" href="/css/mobgen/mobgen.css">

    <style type="text/css"></style><style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style>

	<script>
		$(function () {
			$('#content').children().hide().fadeIn(250);
		});
	</script>
</head>
<!-- body data-color="grey" class="flat" cz-shortcut-listen="true" -->
<body data-color="grey"  cz-shortcut-listen="true">
<div id="wrapper">
<div id="header">
    <h1><a href="/site">MOBGEN Projects</a></h1>
    <a id="menu-trigger" href="/site"><i class="fa fa-bars"></i></a>
</div>
<div id="user-nav">
    <?php if (!Yii::app()->user->isGuest) { ?>
        <ul class="btn-group" style="width: auto; margin: 0px;">
            <li class=""><span class="text hello">Hi, <?php echo Yii::app()->user->id; ?></span></li>
            <li class="btn"><a title="" href="/admin/editUser?id=<?php echo Webuser::model()->getUserId(); ?>"><i class="fa fa-user"></i> <span class="text">Profile</span></a></li>
            <!--
            <li class="btn dropdown" id="menu-messages"><a href="./js/Unicorn Admin.html" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="fa fa-envelope"></i> <span class="text">Messages</span> <span class="label label-danger">5</span> <b class="caret"></b></a>
                <ul class="dropdown-menu messages-menu">
                    <li class="title"><i class="fa fa-envelope-alt"></i>Messages<a class="title-btn" href="./js/Unicorn Admin.html" title="Write new message"><i class="fa fa-share"></i></a></li>
                    <li class="message-item">
                        <a href="./js/Unicorn Admin.html">
                            <img alt="User Icon" src="./js/av1.jpg">
                            <div class="message-content">
		                            	<span class="message-time">
			                                3 mins ago
			                            </span>
		                                <span class="message-sender">
		                                    Nunc Cenenatis
		                                </span>
		                                <span class="message">
		                                    Hi, can you meet me at the office tomorrow morning?
		                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="message-item">
                        <a href="./js/Unicorn Admin.html">
                            <img alt="User Icon" src="./js/av1.jpg">
                            <div class="message-content">
		                            	<span class="message-time">
			                                3 mins ago
			                            </span>
		                                <span class="message-sender">
		                                    Nunc Cenenatis
		                                </span>
		                                <span class="message">
		                                    Hi, can you meet me at the office tomorrow morning?
		                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="message-item">
                        <a href="./js/Unicorn Admin.html">
                            <img alt="User Icon" src="./js/av1.jpg">
                            <div class="message-content">
		                            	<span class="message-time">
			                                3 mins ago
			                            </span>
		                                <span class="message-sender">
		                                    Nunc Cenenatis
		                                </span>
		                                <span class="message">
		                                    Hi, can you meet me at the office tomorrow morning?
		                                </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            -->
            <!-- <li class="btn"><a title="" href="/cms/setting/"><i class="fa fa-cog"></i> <span class="text">Settings</span></a></li> -->
            <li class="btn"><a title="" href="/site/logout"><i class="fa fa-share"></i> <span class="text">Logout</span></a></li>
        </ul>
    <?php } ?>
</div>

<!--
<div id="switcher">
    <div id="switcher-inner">
        <h3>Theme Options</h3>
        <h4>Colors</h4>
        <p id="color-style">
            <a data-color="orange" title="Orange" class="button-square orange-switcher" href="./js/Unicorn Admin.html"></a>
            <a data-color="turquoise" title="Turquoise" class="button-square turquoise-switcher" href="./js/Unicorn Admin.html"></a>
            <a data-color="blue" title="Blue" class="button-square blue-switcher" href="./js/Unicorn Admin.html"></a>
            <a data-color="green" title="Green" class="button-square green-switcher" href="./js/Unicorn Admin.html"></a>
            <a data-color="red" title="Red" class="button-square red-switcher" href="./js/Unicorn Admin.html"></a>
            <a data-color="purple" title="Purple" class="button-square purple-switcher" href="./js/Unicorn Admin.html"></a>
            <a href="./js/Unicorn Admin.html" data-color="grey" title="Grey" class="button-square grey-switcher active"></a>
        </p>
        <h4 class="visible-lg">Layout Type</h4>
        <p id="layout-type">
            <a data-option="flat" class="button active" href="./js/Unicorn Admin.html">Flat</a>
            <a data-option="old" class="button" href="./js/Unicorn Admin.html">Old</a>
        </p>

    </div>
    <div id="switcher-button">
        <i class="fa fa-cogs"></i>
    </div>
</div>
-->


<div id="sidebar" tabindex="5000" style="">
    <?php if (!Yii::app()->user->isGuest) { ?>
        <div id="search">
            <input type="text" placeholder="Search here..."><button type="submit" class="tip-right" title="" data-original-title="Search"><i class="fa fa-search"></i></button>
        </div>
        <?php $this->widget('MainMenu'); ?>
    <?php } ?>
</div>

<div id="content">
        <?php //foreach (Yii::app()->user->getFlashes() as $key => $message) echo '<div class="flash-' . $key . '">' . $message . "</div>\n"; ?>
        <?php echo $content; ?>
</div>
<div class="row">
    <div id="footer" class="col-xs-12">
        &copy; <?php echo date('Y'); ?> MOBGEN. All rights reserved.
    </div>
</div>
</div>

<script src="/js/excanvas.min.js"></script>
<!--
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui.custom.js"></script>
-->

<script src="/js/bootstrap.min.js"></script>

<script src="/js/jquery.flot.min.js"></script>
<script src="/js/jquery.flot.resize.min.js"></script>
<script src="/js/jquery.sparkline.min.js"></script>
<script src="/js/fullcalendar.min.js"></script>

<script src="/js/jquery.nicescroll.min.js"></script>
<script src="/js/mobgen.js"></script>
<!--
<script src="/js/mobgen.dashboard.js"></script>
-->

<div id="ascrail2000" class="nicescroll-rails" style="width: 7px; z-index: 9999; cursor: default; position: fixed; top: 0px; left: 198px; height: 47px; display: block; opacity: 0;"><div style="position: relative; top: 0px; float: right; width: 5px; height: 32px; border: 1px solid rgb(255, 255, 255); border-radius: 5px; background-color: rgb(66, 66, 66); background-clip: padding-box;"></div></div><div id="ascrail2000-hr" class="nicescroll-rails" style="height: 7px; z-index: 9999; top: 561px; left: 0px; position: fixed; cursor: default; display: none; width: 198px; opacity: 0;"><div style="position: relative; top: 0px; height: 5px; width: 205px; border: 1px solid rgb(255, 255, 255); border-radius: 5px; background-color: rgb(66, 66, 66); background-clip: padding-box;"></div></div>
</body>
</html>
