<?php
/* @var $this TransactionReturnOrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Return Orders',
);

$this->menu=array(
	array('label'=>'Create TransactionReturnOrder', 'url'=>array('create')),
	array('label'=>'Manage TransactionReturnOrder', 'url'=>array('admin')),
);
?>

<h1>Transaction Return Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
