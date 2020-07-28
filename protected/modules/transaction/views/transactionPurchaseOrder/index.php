<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Purchase Orders',
);

$this->menu=array(
	array('label'=>'Create TransactionPurchaseOrder', 'url'=>array('create')),
	array('label'=>'Manage TransactionPurchaseOrder', 'url'=>array('admin')),
);
?>

<h1>Transaction Purchase Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
