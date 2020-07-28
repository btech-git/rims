<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs=array(
	'Transaction Delivery Orders'=>array('admin'),
	$deliveryOrder->header->id=>array('view','id'=>$deliveryOrder->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionDeliveryOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionDeliveryOrder', 'url'=>array('create')),
	array('label'=>'View TransactionDeliveryOrder', 'url'=>array('view', 'id'=>$deliveryOrder->header->id)),
	array('label'=>'Manage TransactionDeliveryOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(
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
