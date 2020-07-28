<?php
/* @var $this InventoryDetailController */
/* @var $model InventoryDetail */

$this->breadcrumbs=array(
	'Inventory Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InventoryDetail', 'url'=>array('index')),
	array('label'=>'Create InventoryDetail', 'url'=>array('create')),
	array('label'=>'Update InventoryDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InventoryDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InventoryDetail', 'url'=>array('admin')),
);
?>

<h1>View InventoryDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'inventory_id',
		'product_id',
		'warehouse_id',
		'transaction_type',
		'transaction_number',
		'transaction_date',
		'stock_in',
		'stock_out',
		'notes',
	),
)); ?>
