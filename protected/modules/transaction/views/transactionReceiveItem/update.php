<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs=array(
	'Transaction Receive Item'=>array('admin'),
	$receiveItem->header->id=>array('view','id'=>$receiveItem->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionReceiveItem', 'url'=>array('index')),
	array('label'=>'Create TransactionReceiveItem', 'url'=>array('create')),
	array('label'=>'View TransactionReceiveItem', 'url'=>array('view', 'id'=>$receiveItem->header->id)),
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