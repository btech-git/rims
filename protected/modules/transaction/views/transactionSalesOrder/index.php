<?php
/* @var $this TransactionSalesOrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Sales Orders',
);

$this->menu=array(
	array('label'=>'Create TransactionSalesOrder', 'url'=>array('create')),
	array('label'=>'Manage TransactionSalesOrder', 'url'=>array('admin')),
);
?>

<h1>Transaction Sales Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
