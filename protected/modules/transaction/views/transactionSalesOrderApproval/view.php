<?php
/* @var $this TransactionSalesOrderApprovalController */
/* @var $model TransactionSalesOrderApproval */

$this->breadcrumbs=array(
	'Transaction Sales Order Approvals'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderApproval', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderApproval', 'url'=>array('create')),
	array('label'=>'Update TransactionSalesOrderApproval', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransactionSalesOrderApproval', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransactionSalesOrderApproval', 'url'=>array('admin')),
);
?>

<h1>View TransactionSalesOrderApproval #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sales_order_id',
		'revision',
		'approval_type',
		'date',
		'supervisor_id',
		'note',
	),
)); ?>
