<?php
/* @var $this TransaksiOrderPenjualanController */
/* @var $model TransaksiOrderPenjualan */

$this->breadcrumbs=array(
	'Transaction Sales Orders'=>array('admin'),
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
	'transferRequest'=>$transferRequest,
	// 'transferRequestDetail'=>$transferRequestDetail,
	'historis'=>$historis
	
	)); ?>
</div>

