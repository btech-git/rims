<?php
/* @var $this TransactionSentRequestDetailController */
/* @var $model TransactionSentRequestDetail */

$this->breadcrumbs=array(
	'Transaction Sent Request Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionSentRequestDetail', 'url'=>array('index')),
	array('label'=>'Manage TransactionSentRequestDetail', 'url'=>array('admin')),
);
?>

<h1>Create TransactionSentRequestDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>