<?php
/* @var $this TransactionSalesOrderDetailApprovalController */
/* @var $model TransactionSalesOrderDetailApproval */

$this->breadcrumbs=array(
	'Transaction Sales Order Detail Approvals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderDetailApproval', 'url'=>array('index')),
	array('label'=>'Manage TransactionSalesOrderDetailApproval', 'url'=>array('admin')),
);
?>

<h1>Create TransactionSalesOrderDetailApproval</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>