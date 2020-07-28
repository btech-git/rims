<?php
/* @var $this VehicleCarSubDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vehicle Car Sub Details',
);

$this->menu=array(
	array('label'=>'Create VehicleCarSubDetail', 'url'=>array('create')),
	array('label'=>'Manage VehicleCarSubDetail', 'url'=>array('admin')),
);
?>

<h1>Vehicle Car Sub Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
