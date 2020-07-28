<?php
/* @var $this ChasisCodeController */
/* @var $model ChasisCode */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Chassis Codes'=>array('admin'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List ChasisCode', 'url'=>array('index')),
	array('label'=>'Manage ChasisCode', 'url'=>array('admin')),
);*/
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/chasisCode/admin';?>">Chassis Code</a>
			<span>New Chassis Code</span>
		</div>
	</div>
</div>-->


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>