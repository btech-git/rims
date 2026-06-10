<?php
$this->breadcrumbs=array(
	'Sale Receipt'=>array('index'),
	'Update',
);
?>

<h1>Update Tanda Terima Penjualan</h1>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'saleReceipt' => $saleReceipt,
        'customer' => $customer,
        'invoiceHeader' => $invoiceHeader,
        'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
    )); ?>
</div>