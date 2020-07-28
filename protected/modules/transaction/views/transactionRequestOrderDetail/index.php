<?php
/* @var $this TransactionRequestOrderDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Request Order Details',
);

$this->menu=array(
	array('label'=>'Create TransactionRequestOrderDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionRequestOrderDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Request Order Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
