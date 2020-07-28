<?php
/* @var $this WarehouseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Warehouses',
);

$this->menu=array(
	array('label'=>'Create Warehouse', 'url'=>array('create')),
	array('label'=>'Manage Warehouse', 'url'=>array('admin')),
);
?>

<h1>Warehouses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
