<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs=array(
	'Transaction Sales Orders'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TransactionSalesOrder', 'url'=>array('index')),
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


