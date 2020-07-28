<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
	'Transaction Delivery Orders'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionDeliveryOrder', 'url'=>array('index')),
	array('label'=>'Manage TransactionDeliveryOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('deliveryOrder'=>$deliveryOrder,
		'deliveryOrder'=>$deliveryOrder,
		'sent'=>$sent,
		'sentDataProvider'=>$sentDataProvider,
		'sales'=>$sales,
		'salesDataProvider'=>$salesDataProvider,
		'consignment'=>$consignment,
		'consignmentDataProvider'=>$consignmentDataProvider,
		'transfer'=>$transfer,
		'transferDataProvider'=>$transferDataProvider,
	)); ?>
</div>