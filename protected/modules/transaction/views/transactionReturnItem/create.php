<?php
/* @var $this TransactionTransferRequestController */
/* @var $model TransactionTransferRequest */

$this->breadcrumbs=array(
	'Transaction Return Item'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionReturnItem', 'url'=>array('index')),
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