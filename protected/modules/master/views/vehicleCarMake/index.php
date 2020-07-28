<?php
/* @var $this VehicleCarMakeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicle Car Makes',
);

$this->menu=array(
	array('label'=>'Create VehicleCarMake', 'url'=>array('create')),
	array('label'=>'Manage VehicleCarMake', 'url'=>array('admin')),
);
?>

<h1>Vehicle Car Makes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
