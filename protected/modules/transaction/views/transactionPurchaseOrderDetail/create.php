<?php
/* @var $this TransactionPurchaseOrderDetailController */
/* @var $model TransactionPurchaseOrderDetail */

$this->breadcrumbs=array(
	'Transaction Purchase Order Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionPurchaseOrderDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionPurchaseOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionPurchaseOrderDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>