<?php
/* @var $this TransactionReceiveItemDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Receive Item Details',
);

$this->menu=array(
	array('label'=>'Create TransactionReceiveItemDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionReceiveItemDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Receive Item Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
