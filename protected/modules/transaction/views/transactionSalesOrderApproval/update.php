<?php
/* @var $this TransactionSalesOrderApprovalController */
/* @var $model TransactionSalesOrderApproval */

$this->breadcrumbs=array(
	'Transaction Sales Order Approvals'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderApproval', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderApproval', 'url'=>array('create')),
	array('label'=>'View TransactionSalesOrderApproval', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionSalesOrderApproval', 'url'=>array('admin')),
);
?>

<h1>Update TransactionSalesOrderApproval <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>