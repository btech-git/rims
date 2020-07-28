<?php
/* @var $this VehicleCarSubModelDetailController */
/* @var $model VehicleCarSubModelDetail */

$this->breadcrumbs=array(
	'Vehicle',
	'Vehicle Car Sub Model Details'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List VehicleCarSubModelDetail', 'url'=>array('index')),
	array('label'=>'Manage VehicleCarSubModelDetail', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model,'vehicleCarSubModel'=>$vehicleCarSubModel,
	'vehicleCarSubModelDataProvider'=>$vehicleCarSubModelDataProvider)); ?>
</div>