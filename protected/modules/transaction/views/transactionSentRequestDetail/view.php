<?php
/* @var $this TransactionSentRequestDetailController */
/* @var $model TransactionSentRequestDetail */

$this->breadcrumbs=array(
	'Transaction Sent Request Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionSentRequestDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionSentRequestDetail', 'url'=>array('create')),
	array('label'=>'Update TransactionSentRequestDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionSentRequestDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionSentRequestDetail', 'url'=>array('admin')),
);
?>

<h1>View TransactionSentRequestDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sent_request_id',
		'product_id',
		'quantity',
		'unit_price',
		'unit_id',
		'amount',
	),
)); ?>
