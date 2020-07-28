<?php
/* @var $this TransactionReturnItemDetailController */
/* @var $model TransactionReturnItemDetail */

$this->breadcrumbs=array(
	'Transaction Return Item Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionReturnItemDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionReturnItemDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionReturnItemDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionReturnItemDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionReturnItemDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionReturnItemDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'return_item_id',
		'product_id',
		'return_type',
		'quantity',
		'quantity_delivery',
		'quantity_left',
		'note',
		'barcode_product',
	),
)); ?>
