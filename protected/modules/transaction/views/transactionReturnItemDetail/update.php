<?php
/* @var $this TransactionReturnItemDetailController */
/* @var $model TransactionReturnItemDetail */

$this->breadcrumbs=array(
	'Transaction Return Item Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionReturnItemDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionReturnItemDetail', 'url'=>array('create')),
	array('label'=>'View TransactionReturnItemDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionReturnItemDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionReturnItemDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>