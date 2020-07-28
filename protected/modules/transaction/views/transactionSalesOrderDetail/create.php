<?php
/* @var $this TransactionSalesOrderDetailController */
/* @var $model TransactionSalesOrderDetail */

$this->breadcrumbs=array(
	'Transaction Sales Order Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionSalesOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionSalesOrderDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>