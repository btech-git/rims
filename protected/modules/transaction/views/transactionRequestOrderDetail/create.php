<?php
/* @var $this TransactionRequestOrderDetailController */
/* @var $model TransactionRequestOrderDetail */

$this->breadcrumbs=array(
	'Transaction Request Order Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionRequestOrderDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionRequestOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionRequestOrderDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>