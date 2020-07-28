<?php
/* @var $this InventoryDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inventory Details',
);

$this->menu=array(
	array('label'=>'Create InventoryDetail', 'url'=>array('create')),
	array('label'=>'Manage InventoryDetail', 'url'=>array('admin')),
);
?>

<h1>Inventory Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
