<?php
/* @var $this WorkOrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Work Orders',
);

$this->menu=array(
	array('label'=>'Create WorkOrder', 'url'=>array('create')),
	array('label'=>'Manage WorkOrder', 'url'=>array('admin')),
);
?>

<h1>Work Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
