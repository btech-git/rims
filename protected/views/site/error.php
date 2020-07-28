<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
//$this->breadcrumbs=array('Error');
?>


<div class="row">
	<div class="small-12 columns">
		<div class="row">
			<div class="small-6 columns">
				<h1 style="font-size: 3rem; font-weight: bold; color: #999;">Oops! : <?php echo $code; ?></h1>
				<hr />
			</div>		
		</div>
		<div class="error">
			<p><?php echo CHtml::encode($message); ?>. 
			<br />
			Would you like to go to <a href="#">homepage</a> instead?</p>
		</div>
		<!-- <img src="<?php echo Yii::app()->baseUrl.'/images/under-construction.png';?>"> -->
	</div>
</div>

