<?php
/* @var $this TransactionReturnOrderDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Return Order Details',
);

$this->menu=array(
	array('label'=>'Create TransactionReturnOrderDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionReturnOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Return Order Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
