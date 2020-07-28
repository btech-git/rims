<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
		<?php $id=1;?>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		</head>
		<body class="login">

		<div id="content">
			<div class="row">
				<div class="small-12 medium-4 medium-centered columns">
					<div class="panel-login">
						<div class="header clearfix">
							<a href="#"><strong>RAPERIND</strong> MOTOR<strong class="right">Admin</strong></a>
						</div>
						<div class="content">
							<?php echo $content;?>
						</div>
					</div>
				</div>
			</div>
		</div>

			<!-- end content -->
			<?php include 'footer.php';?>

		</div>
		
		<?php /*
		<script>
		  $(document).ready(function(){
		    $('#sidebar').stickyMojo({footerID: '#footer', contentID: '#content'});
		  });
		</script>*/
		?>

		</body>
</html>
