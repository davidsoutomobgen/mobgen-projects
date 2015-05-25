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
	<script>
		$(function () {
			$('#content').children().hide().fadeIn(250);
		});
	</script>
</head>
<body>
	<?php if (YII_DEBUG) echo '<div style="border:1px solid red;background-color:#FF8080;height:21px;font-weight:bold;font-size:16px;color:#000;overflow:hidden;text-align:center;">debug mode - debug mode - debug mode - debug mode - debug mode - debug mode - debug mode - debug mode - debug mode - debug mode - debug mode</div>'; ?>
	<div class="container" id="page">
		<div id="header">
			<div class="wrapper">
				<a href="<?php echo _url('site'); ?>">
					<div id="branding">
						<h1>MOBGEN CMS</h1>
					</div>
				</a>
				<?php if (!Yii::app()->user->isGuest) : ?>
					<div id="status">Welcome <?php echo Yii::app()->user->name; ?>. <?php echo CHtml::link('Logout', _url('site/logout')); ?></div>
					<div class="clear"></div>
					<?php $this->widget('MainMenu'); ?>
				<?php endif; ?>
				<div class="clear"></div>
			</div>
		</div>
		<div id="content">
			<div class="wrapper">
				<?php foreach (Yii::app()->user->getFlashes() as $key => $message) echo '<div class="flash-' . $key . '">' . $message . "</div>\n"; ?>
				<?php echo $content; ?>
			</div>
		</div>
		<div id="footer">
			<div class="wrapper">
				<p class="copyright">
					&copy; <?php echo date('Y'); ?> MOBGEN. All rights reserved.
				</p>
			</div>
		</div>
	</div>
</body>
</html>