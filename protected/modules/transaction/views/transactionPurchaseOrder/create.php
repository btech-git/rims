<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $model TransactionPurchaseOrder */

$this->breadcrumbs = array(
    'Transaction Purchase Orders' => array('admin'),
    'Create',
);

$this->menu = array(
    array('label' => 'List TransactionPurchaseOrder', 'url' => array('index')),
    array('label' => 'Manage TransactionPurchaseOrder', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'purchaseOrder' => $purchaseOrder,
        'supplier' => $supplier,
        'supplierDataProvider' => $supplierDataProvider,
        // 'request'=>$request,
        // 'requestDataProvider'=>$requestDataProvider,
        'product' => $product,
        'productDataProvider' => $productDataProvider,
        'price' => $price,
        'priceDataProvider' => $priceDataProvider,
    )); ?>
</div>

