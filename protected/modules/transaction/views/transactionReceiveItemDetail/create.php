<?php
/* @var $this TransactionReceiveItemDetailController */
/* @var $model TransactionReceiveItemDetail */

$this->breadcrumbs=array(
	'Transaction Receive Item Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionReceiveItemDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionReceiveItemDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionReceiveItemDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>