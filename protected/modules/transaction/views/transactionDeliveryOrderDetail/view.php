<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $model TransactionDeliveryOrderDetail */

$this->breadcrumbs=array(
	'Transaction Delivery Order Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionDeliveryOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionDeliveryOrderDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionDeliveryOrderDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionDeliveryOrderDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionDeliveryOrderDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionDeliveryOrderDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'delivery_order_id',
		'product_id',
		'quantity_request',
		'quantity_delivery',
		'quantity_request_left',
		'note',
		'barcode_product',
	),
)); ?>
