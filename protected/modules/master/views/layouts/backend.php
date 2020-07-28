<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fontface.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation-datepicker.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/rims.css" />
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/modernizr.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/foundation-datepicker.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/isotope.pkgd.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/imagesloaded.pkgd.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
		<style type="text/css">
			#utilities { background:#ccc; padding:5px 0; }
			#utilities .row div {font-size:12px; text-align: right; padding:0 20px;}
			#utilities .row div a { color:#185796; }
			#utilities .row div a:hover {text-decoration: underline;}
			#mainmenu ul ul {min-width: 110px}
		</style><?php $id=2;?>
		<?php include 'header.php';?>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
		<body class="">
		<?php include 'menu.php';?>

		<div id="content">
			<?php echo $content;?>
		</div>
		<!-- end content -->
		<?php include 'footer.php';?>
		</body>
</html>
