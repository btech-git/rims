<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
?>
<div style="font-size:16px; text-align:center">
	<div style="font-size:30px">Raperind Information Management System (RIMS)</div>
	<br/><br/>

	<img src="<?php echo Yii::app()->baseUrl.'/images/rap-logo.png';?>">
	<br/><br/>
	<?php 
	
	if(Yii::app()->user->isGuest){ ?>
	Please login to access RIMS	

	<br/><br/>
	
	<a href="<?php echo Yii::app()->baseUrl.'/site/login';?>" class="button cbutton">CLICK HERE</a>
	<?php } ?>
	<br/><br/>

</div>
