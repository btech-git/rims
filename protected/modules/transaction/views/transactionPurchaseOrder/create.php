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
        'purchaseOrderDate' => $purchaseOrderDate,
        'purchaseOrderHour' => $purchaseOrderHour,
        'purchaseOrderMinute' => $purchaseOrderMinute,
        'supplier' => $supplier,
        'supplierDataProvider' => $supplierDataProvider,
        // 'request'=>$request,
        // 'requestDataProvider'=>$requestDataProvider,
        'product' => $product,
        'productDataProvider' => $productDataProvider,
        'price' => $price,
        'priceDataProvider' => $priceDataProvider,
        'destinationBranchDataProvider' => $destinationBranchDataProvider,
        'registrationTransaction' => $registrationTransaction,
        'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
    )); ?>
</div>

