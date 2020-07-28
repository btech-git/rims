<?php
/* @var $this InventoryDetailController */
/* @var $model InventoryDetail */

$this->breadcrumbs=array(
	'Inventory Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InventoryDetail', 'url'=>array('index')),
	array('label'=>'Manage InventoryDetail', 'url'=>array('admin')),
);
?>

<h1>Create InventoryDetail</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>