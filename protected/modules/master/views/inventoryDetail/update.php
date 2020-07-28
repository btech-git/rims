<?php
/* @var $this InventoryDetailController */
/* @var $model InventoryDetail */

$this->breadcrumbs=array(
	'Inventory Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InventoryDetail', 'url'=>array('index')),
	array('label'=>'Create InventoryDetail', 'url'=>array('create')),
	array('label'=>'View InventoryDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InventoryDetail', 'url'=>array('admin')),
);
?>

<h1>Update InventoryDetail <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>