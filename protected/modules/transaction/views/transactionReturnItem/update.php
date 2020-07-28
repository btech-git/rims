<?php
/* @var $this TransactionReceiveItemController */
/* @var $returnItem->header TransactionReceiveItem */

$this->breadcrumbs=array(
	'Transaction Return Item'=>array('admin'),
	$returnItem->header->id=>array('view','id'=>$returnItem->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionReturnItem', 'url'=>array('index')),
	array('label'=>'Create TransactionReturnItem', 'url'=>array('create')),
	array('label'=>'View TransactionReturnItem', 'url'=>array('view', 'id'=>$returnItem->header->id)),
	array('label'=>'Manage TransactionReturnItem', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('returnItem'=>$returnItem,
	'transfer'=>$transfer,
		'transferDataProvider'=>$transferDataProvider,
		'sales'=>$sales,
		'salesDataProvider'=>$salesDataProvider,
		'delivery'=>$delivery,
		'deliveryDataProvider'=>$deliveryDataProvider,
	)); ?>
</div>