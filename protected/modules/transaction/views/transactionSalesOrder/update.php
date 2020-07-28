<?php
/* @var $this TransactionRequestOrderController */
/* @var $requestOrder->header TransactionRequestOrder */

$this->breadcrumbs=array(
	'Transaction Sales Orders'=>array('admin'),
	$salesOrder->header->id=>array('view','id'=>$salesOrder->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionSalesOrder', 'url'=>array('create')),
	array('label'=>'View TransactionSalesOrder', 'url'=>array('view', 'id'=>$salesOrder->header->id)),
	array('label'=>'Manage TransactionSalesOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('salesOrder'=>$salesOrder,
		'customer'=>$customer,
		'customerDataProvider'=>$customerDataProvider,
		// 'request'=>$request,
		// 'requestDataProvider'=>$requestDataProvider,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider,
	)); ?>
</div>
