<?php
/* @var $this TransactionRequestOrderController */
/* @var $requestOrder->header TransactionRequestOrder */

$this->breadcrumbs=array(
	'Transaction Request Orders'=>array('admin'),
	$purchaseOrder->header->id=>array('view','id'=>$purchaseOrder->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransactionRequestOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionRequestOrder', 'url'=>array('create')),
	array('label'=>'View TransactionRequestOrder', 'url'=>array('view', 'id'=>$purchaseOrder->header->id)),
	array('label'=>'Manage TransactionRequestOrder', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('purchaseOrder'=>$purchaseOrder,
		'supplier'=>$supplier,
		'supplierDataProvider'=>$supplierDataProvider,
		// 'request'=>$request,
		// 'requestDataProvider'=>$requestDataProvider,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider,
        'price' => $price,
        'priceDataProvider' => $priceDataProvider,
	)); ?>
</div>