<?php
/* @var $this TransactionDeliveryOrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Delivery Orders',
);

$this->menu=array(
	array('label'=>'Create TransactionDeliveryOrder', 'url'=>array('create')),
	array('label'=>'Manage TransactionDeliveryOrder', 'url'=>array('admin')),
);
?>

<h1>Transaction Delivery Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
