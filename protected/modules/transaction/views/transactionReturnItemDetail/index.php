<?php
/* @var $this TransactionReturnItemDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Return Item Details',
);

$this->menu=array(
	array('label'=>'Create TransactionReturnItemDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionReturnItemDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Return Item Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
