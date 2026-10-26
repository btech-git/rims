<?php
$this->breadcrumbs = array(
    'Tanda Terima Penjualan' => array('index'),
    'Create',
);
?>

<h1>Rekap Tagihan</h1>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'saleReceipt' => $saleReceipt,
        'invoiceHeader' => $invoiceHeader,
        'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
    )); ?>
</div>