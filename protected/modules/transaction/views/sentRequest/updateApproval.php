<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Transaction Sent Request'=>array('admin'),
	'Update Approval',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrder', 'url'=>array('index')),
	array('label'=>'Manage TransactionSalesOrder', 'url'=>array('admin')),
);
?>

<div id="maincontent">
<?php echo $this->renderPartial('_Approval', array(
	'model'=>$model,
	'sentRequest'=>$sentRequest,
	// 'sentRequestDetail'=>$sentRequestDetail,
	'historis'=>$historis
	
	)); ?>
</div>

