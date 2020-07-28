<?php
/* @var $this VehicleCarSubModelDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicle Car Sub Model Details',
);

$this->menu=array(
	array('label'=>'Create VehicleCarSubModelDetail', 'url'=>array('create')),
	array('label'=>'Manage VehicleCarSubModelDetail', 'url'=>array('admin')),
);
?>

<h1>Vehicle Car Sub Model Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
