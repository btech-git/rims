<?php
/* @var $this TransactionRequestOrderDetailController */
/* @var $model TransactionRequestOrderDetail */

$this->breadcrumbs=array(
	'Transaction Request Order Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionRequestOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionRequestOrderDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionRequestOrderDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionRequestOrderDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionRequestOrderDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionRequestOrderDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request_order_id',
		'product_id',
		'supplier_id',
		'unit_id',
		'discount_percent',
		'discount_nominal',
		'quantity',
		'price',
		'subtotal',
		'purchase_order_quantity',
		'request_order_quantity',
		'notes',
	),
)); ?>
