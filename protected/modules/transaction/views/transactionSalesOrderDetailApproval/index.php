<?php
/* @var $this TransactionSalesOrderDetailApprovalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Sales Order Detail Approvals',
);

$this->menu=array(
	array('label'=>'Create TransactionSalesOrderDetailApproval', 'url'=>array('create')),
	array('label'=>'Manage TransactionSalesOrderDetailApproval', 'url'=>array('admin')),
);
?>

<h1>Transaction Sales Order Detail Approvals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
