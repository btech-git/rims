<?php
/* @var $this VehicleCarModelController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicle Car Models',
);

$this->menu=array(
	array('label'=>'Create VehicleCarModel', 'url'=>array('create')),
	array('label'=>'Manage VehicleCarModel', 'url'=>array('admin')),
);
?>

<h1>Vehicle Car Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
