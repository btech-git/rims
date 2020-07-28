<?php
/* @var $this TransactionSalesOrderDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Sales Order Details',
);

$this->menu=array(
	array('label'=>'Create TransactionSalesOrderDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionSalesOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Sales Order Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
