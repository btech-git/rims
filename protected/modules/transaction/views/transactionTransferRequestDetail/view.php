<?php
/* @var $this TransactionTransferRequestDetailController */
/* @var $model TransactionTransferRequestDetail */

$this->breadcrumbs=array(
	'Transaction Transfer Request Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionTransferRequestDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionTransferRequestDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionTransferRequestDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionTransferRequestDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionTransferRequestDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionTransferRequestDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transfer_request_id',
		'product_id',
		'quantity',
		'unit_price',
		'unit_id',
		'amount',
	),
)); ?>
