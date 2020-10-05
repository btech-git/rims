<?php
/* @var $this VehicleInspectionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicle Inspections',
);

$this->menu=array(
	array('label'=>'Create VehicleInspection', 'url'=>array('create')),
	array('label'=>'Manage VehicleInspection', 'url'=>array('admin')),
);
?>

<h1>Vehicle Inspections</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
