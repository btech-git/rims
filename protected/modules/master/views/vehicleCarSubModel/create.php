<?php
/* @var $this VehicleCarSubModelController */
/* @var $model VehicleCarSubModel */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Vehicle Car Sub Models'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List VehicleCarSubModel', 'url'=>array('index')),
	array('label'=>'Manage VehicleCarSubModel', 'url'=>array('admin')),
);*/
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubModel/admin';?>">Vehicle Car Sub Model</a>
			<span>New Vehicle Car Sub Model</span>
		</div>
	</div>
</div>-->



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>