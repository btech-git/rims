<?php
/* @var $this TransactionReceiveItemDetailController */
/* @var $model TransactionReceiveItemDetail */

$this->breadcrumbs=array(
	'Transaction Receive Item Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionReceiveItemDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionReceiveItemDetail', 'url'=>array('create')),
	array('label'=>'View TransactionReceiveItemDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionReceiveItemDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionReceiveItemDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>