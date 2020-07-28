<?php
/* @var $this TransactionReturnOrderDetailController */
/* @var $model TransactionReturnOrderDetail */

$this->breadcrumbs=array(
	'Transaction Return Order Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionReturnOrderDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionReturnOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionReturnOrderDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>