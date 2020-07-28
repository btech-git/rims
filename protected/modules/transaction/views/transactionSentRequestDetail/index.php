<?php
/* @var $this TransactionSentRequestDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Sent Request Details',
);

$this->menu=array(
	array('label'=>'Create TransactionSentRequestDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionSentRequestDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Sent Request Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
