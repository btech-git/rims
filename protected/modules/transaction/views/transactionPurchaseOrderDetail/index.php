<?php
/* @var $this TransactionPurchaseOrderDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Purchase Order Details',
);

$this->menu=array(
	array('label'=>'Create TransactionPurchaseOrderDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionPurchaseOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Purchase Order Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
