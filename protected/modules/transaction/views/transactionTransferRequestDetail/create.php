<?php
/* @var $this TransactionTransferRequestDetailController */
/* @var $model TransactionTransferRequestDetail */

$this->breadcrumbs=array(
	'Transaction Transfer Request Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionTransferRequestDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionTransferRequestDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionTransferRequestDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>