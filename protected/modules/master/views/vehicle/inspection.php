<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicle'=>array('admin'),
	'Vehicles'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List Vehicle', 'url'=>array('index')),
	array('label'=>'Create Vehicle', 'url'=>array('create')),
	array('label'=>'View Vehicle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Vehicle', 'url'=>array('admin')),
);*/
?>

<div id="maincontent">
	<?php $this->renderPartial('_inspectionForm', array(
		'vehicle'=>$vehicle,
		'inspection'=>$inspection,
		'inspectionDataProvider'=>$inspectionDataProvider,
	)); ?>
</div>
