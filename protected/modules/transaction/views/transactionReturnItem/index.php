<?php
/* @var $this TransactionReturnItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Return Items',
);

$this->menu=array(
	array('label'=>'Create TransactionReturnItem', 'url'=>array('create')),
	array('label'=>'Manage TransactionReturnItem', 'url'=>array('admin')),
);
?>

<h1>Transaction Return Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
