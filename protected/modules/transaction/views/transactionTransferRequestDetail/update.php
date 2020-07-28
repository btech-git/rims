<?php
/* @var $this TransactionTransferRequestDetailController */
/* @var $model TransactionTransferRequestDetail */

$this->breadcrumbs=array(
	'Transaction Transfer Request Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionTransferRequestDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionTransferRequestDetail', 'url'=>array('create')),
	array('label'=>'View TransactionTransferRequestDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionTransferRequestDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionTransferRequestDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>