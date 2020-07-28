<?php
/* @var $this TransactionReturnOrderDetailController */
/* @var $model TransactionReturnOrderDetail */

$this->breadcrumbs=array(
	'Transaction Return Order Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionReturnOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionReturnOrderDetail', 'url'=>array('create')),
	array('label'=>'View TransactionReturnOrderDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionReturnOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionReturnOrderDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>