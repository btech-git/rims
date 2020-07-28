<?php
/* @var $this TransactionReceiveItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Receive Items',
);

$this->menu=array(
	array('label'=>'Create TransactionReceiveItem', 'url'=>array('create')),
	array('label'=>'Manage TransactionReceiveItem', 'url'=>array('admin')),
);
?>

<h1>Transaction Receive Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
