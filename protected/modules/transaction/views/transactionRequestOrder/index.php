<?php
/* @var $this TransactionRequestOrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Request Orders',
);

$this->menu=array(
	array('label'=>'Create TransactionRequestOrder', 'url'=>array('create')),
	array('label'=>'Manage TransactionRequestOrder', 'url'=>array('admin')),
);
?>

<h1>Transaction Request Orders</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
