<?php
/* @var $this TransactionSalesOrderApprovalController */
/* @var $model TransactionSalesOrderApproval */

$this->breadcrumbs=array(
	'Transaction Sales Order Approvals'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderApproval', 'url'=>array('index')),
	array('label'=>'Manage TransactionSalesOrderApproval', 'url'=>array('admin')),
);
?>

<h1>Create TransactionSalesOrderApproval</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>