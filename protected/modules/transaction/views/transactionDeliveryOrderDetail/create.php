<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $model TransactionDeliveryOrderDetail */

$this->breadcrumbs=array(
	'Transaction Delivery Order Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionDeliveryOrderDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionDeliveryOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionDeliveryOrderDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>