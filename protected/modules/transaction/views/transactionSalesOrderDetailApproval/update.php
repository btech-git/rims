<?php
/* @var $this TransactionSalesOrderDetailApprovalController */
/* @var $model TransactionSalesOrderDetailApproval */

$this->breadcrumbs=array(
	'Transaction Sales Order Detail Approvals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderDetailApproval', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderDetailApproval', 'url'=>array('create')),
	array('label'=>'View TransactionSalesOrderDetailApproval', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionSalesOrderDetailApproval', 'url'=>array('admin')),
);
?>

<h1>Update TransactionSalesOrderDetailApproval <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>