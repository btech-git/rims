<?php
/* @var $this VehicleCarMakeController */
/* @var $model VehicleCarMake */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Vehicle Car Makes'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VehicleCarMake', 'url'=>array('index')),
	array('label'=>'Create VehicleCarMake', 'url'=>array('create')),
	array('label'=>'View VehicleCarMake', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VehicleCarMake', 'url'=>array('admin')),
);
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarMake/admin';?>">Vehicle Car Make</a>
			
			<span>Update Vehicle Car Make</span>
		</div>
	</div>
</div>-->
<div id="maincontent">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>