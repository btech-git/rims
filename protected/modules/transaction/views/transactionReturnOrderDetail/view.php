<?php
/* @var $this TransactionReturnOrderDetailController */
/* @var $model TransactionReturnOrderDetail */

$this->breadcrumbs=array(
	'Transaction Return Order Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionReturnOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionReturnOrderDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionReturnOrderDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionReturnOrderDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionReturnOrderDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionReturnOrderDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'return_order_id',
		'product_id',
		'qty_request_left',
		'qty_reject',
		'note',
	),
)); ?>
