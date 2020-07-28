<?php
/* @var $this TransactionSalesOrderDetailController */
/* @var $model TransactionSalesOrderDetail */

$this->breadcrumbs=array(
	'Transaction Sales Order Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrderDetail', 'url'=>array('create')),
	array('label'=>'View TransactionSalesOrderDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionSalesOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionSalesOrderDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>