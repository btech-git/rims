<?php
/* @var $this TransactionTransferRequestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Transfer Requests',
);

$this->menu=array(
	array('label'=>'Create TransactionTransferRequest', 'url'=>array('create')),
	array('label'=>'Manage TransactionTransferRequest', 'url'=>array('admin')),
);
?>

<h1>Transaction Transfer Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
