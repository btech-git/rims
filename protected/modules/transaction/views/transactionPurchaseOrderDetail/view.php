<?php
/* @var $this TransactionPurchaseOrderDetailController */
/* @var $model TransactionPurchaseOrderDetail */

$this->breadcrumbs=array(
	'Transaction Purchase Order Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionPurchaseOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionPurchaseOrderDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionPurchaseOrderDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionPurchaseOrderDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionPurchaseOrderDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionPurchaseOrderDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'purchase_order_id',
		'request_order_id',
		'product_id',
		'branch_addressed_to',
		'unit_id',
		'discount_percent',
		'discount_nominal',
		'price',
		'quantity',
		'subtotal',
		'request_order_quantity_rest',
		'receive_order_quantity',
		'purchase_order_quantity_rest',
		'notes',
	),
)); ?>
