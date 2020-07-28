<?php
/* @var $this TransactionRequestOrderDetailController */
/* @var $model TransactionRequestOrderDetail */

$this->breadcrumbs=array(
	'Transaction Request Order Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionRequestOrderDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionRequestOrderDetail', 'url'=>array('create')),
	array('label'=>'View TransactionRequestOrderDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionRequestOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionRequestOrderDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>