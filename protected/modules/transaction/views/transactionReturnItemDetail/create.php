<?php
/* @var $this TransactionReturnItemDetailController */
/* @var $model TransactionReturnItemDetail */

$this->breadcrumbs=array(
	'Transaction Return Item Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionReturnItemDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionReturnItemDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionReturnItemDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>