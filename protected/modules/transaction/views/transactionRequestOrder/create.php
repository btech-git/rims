<?php
/* @var $this TransactionRequestOrderController */
/* @var $model TransactionRequestOrder */

$this->breadcrumbs = array(
    'Transaction Request Orders' => array('admin'),
    'Create',
);

$this->menu = array(
    array('label' => 'List TransactionRequestOrder', 'url' => array('index')),
    array('label' => 'Manage TransactionRequestOrder', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <?php
    echo $this->renderPartial('_form', array(
        'requestOrder' => $requestOrder,
        'supplier' => $supplier,
        'supplierDataProvider' => $supplierDataProvider,
        'product' => $product,
        'productDataProvider' => $productDataProvider,
        'price' => $price,
        'priceDataProvider' => $priceDataProvider
    ));
    ?>
</div>