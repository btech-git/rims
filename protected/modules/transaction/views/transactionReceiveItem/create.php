<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
	'Transaction Receive Item'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionReceiveItem', 'url'=>array('index')),
	array('label'=>'Manage TransactionReceiveItem', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('receiveItem'=>$receiveItem,
		'transfer'=>$transfer,
		'transferDataProvider'=>$transferDataProvider,
		'purchase'=>$purchase,
		'purchaseDataProvider'=>$purchaseDataProvider,
		'consignment'=>$consignment,
		'consignmentDataProvider'=>$consignmentDataProvider,
		'delivery'=>$delivery,
		'deliveryDataProvider'=>$deliveryDataProvider,
	)); ?>
</div>
