<?php
/* @var $this TransactionSalesOrderDetailApprovalController */
/* @var $model TransactionSalesOrderDetailApproval */

$this->breadcrumbs=array(
	'Transaction Sales Order Detail Approvals'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderDetailApproval', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderDetailApproval', 'url'=>array('create')),
	array('label'=>'Update TransactionSalesOrderDetailApproval', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionSalesOrderDetailApproval', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionSalesOrderDetailApproval', 'url'=>array('admin')),
);
?>

<h1>View TransactionSalesOrderDetailApproval #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sales_order_detail_id',
		'revision',
		'approval_type',
		'date',
		'supervisor_id',
		'note',
	),
)); ?>
