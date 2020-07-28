<?php
/* @var $this TransactionSentRequestDetailController */
/* @var $model TransactionSentRequestDetail */

$this->breadcrumbs=array(
	'Transaction Sent Request Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionSentRequestDetail', 'url'=>array('index')),
	array('label'=>'Create TransactionSentRequestDetail', 'url'=>array('create')),
	array('label'=>'View TransactionSentRequestDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransactionSentRequestDetail', 'url'=>array('admin')),
);
?>

<h1>Update TransactionSentRequestDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>