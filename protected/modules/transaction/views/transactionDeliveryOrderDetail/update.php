<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $model TransactionDeliveryOrderDetail */

$this->breadcrumbs=array(
	'Transaction Delivery Order Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionDeliveryOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionDeliveryOrderDetail', 'url'=>array('create')),
	array('label'=>'View TransactionDeliveryOrderDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionDeliveryOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionDeliveryOrderDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>