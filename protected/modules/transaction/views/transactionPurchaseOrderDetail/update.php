<?php
/* @var $this TransactionPurchaseOrderDetailController */
/* @var $model TransactionPurchaseOrderDetail */

$this->breadcrumbs=array(
	'Transaction Purchase Order Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionPurchaseOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionPurchaseOrderDetail', 'url'=>array('create')),
	array('label'=>'View TransactionPurchaseOrderDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionPurchaseOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionPurchaseOrderDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>