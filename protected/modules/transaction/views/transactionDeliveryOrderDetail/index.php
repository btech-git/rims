<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Delivery Order Details',
);

$this->menu=array(
	array('label'=>'Create TransactionDeliveryOrderDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionDeliveryOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Delivery Order Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
