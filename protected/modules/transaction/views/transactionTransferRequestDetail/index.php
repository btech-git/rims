<?php
/* @var $this TransactionTransferRequestDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Transfer Request Details',
);

$this->menu=array(
	array('label'=>'Create TransactionTransferRequestDetail', 'url'=>array('create')),
	array('label'=>'Manage TransactionTransferRequestDetail', 'url'=>array('admin')),
);
?>

<h1>Transaction Transfer Request Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
