<?php
/* @var $this VehicleCarModelController */
/* @var $model VehicleCarModel */

$this->breadcrumbs=array(
	'Vehicle Car Models'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VehicleCarModel', 'url'=>array('index')),
	array('label'=>'Create VehicleCarModel', 'url'=>array('create')),
	array('label'=>'View VehicleCarModel', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VehicleCarModel', 'url'=>array('admin')),
);
?>
<!-- <div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarModel/admin';?>">Vehicle Car Modal</a>
			<span>Update Vehicle Car Model</span>
		</div>
	</div>
</div> -->
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>