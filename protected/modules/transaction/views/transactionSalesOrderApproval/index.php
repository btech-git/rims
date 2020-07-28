<?php
/* @var $this TransactionSalesOrderApprovalController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Sales Order Approvals',
);

$this->menu=array(
	array('label'=>'Create TransactionSalesOrderApproval', 'url'=>array('create')),
	array('label'=>'Manage TransactionSalesOrderApproval', 'url'=>array('admin')),
);
?>

<h1>Transaction Sales Order Approvals</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
