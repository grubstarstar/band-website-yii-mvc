<?php /* @var $this Controller */

Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<link href='http://fonts.googleapis.com/css?family=Cabin:400,600,700,600italic' rel='stylesheet' type='text/css'>

	<title><?php echo strtoupper(CHtml::encode($this->pageTitle)); ?></title>
</head>

<body>

<div class="container" id="page">
	<div id="inner-page">

		<div id="header">
			<div id="logo"><?php echo strtoupper(CHtml::encode(Yii::app()->name)); ?></div>
		</div><!-- header -->

		<div id="mainmenu">
			<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
					array('label'=>'SEE', 'url'=>array('/shows/index')),
					array('label'=>'HEAR', 'url'=>array('/song/index')),
					array('label'=>'KNOW', 'url'=>array('/site/page', 'view'=>'about')),
					// array('label'=>'HOME', 'url'=>array('/site/index'))
					// array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				),
			)); ?>
		</div><!-- mainmenu -->
		
		<?php echo $content; ?>

		<div class="clear"></div>

		<!--div id="footer">
			All songs on this site are Copyright &copy; <?php echo date('Y'); ?> of Alone With Tiger.<br/>
			All Rights Reserved.<br/>
		</div--><!-- footer -->

	</div>
</div><!-- page -->

</body>
</html>