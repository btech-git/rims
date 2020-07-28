<?php
/* @var $this TransactionReceiveItemDetailController */
/* @var $model TransactionReceiveItemDetail */

$this->breadcrumbs=array(
	'Transaction Receive Item Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionReceiveItemDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionReceiveItemDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionReceiveItemDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionReceiveItemDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionReceiveItemDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionReceiveItemDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'receive_item_id',
		'product_id',
		'qty_request',
		'qty_good',
		'qty_reject',
		'qty_more',
		'note',
		'qty_request_left',
		'barcode_product',
	),
)); ?>
