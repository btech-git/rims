<?php
$this->breadcrumbs = array(
	'Sale Payment'=>array('update'),
	'Update',
);
?>

<h1>Revisi Pembayaran Penjualan Barang</h1>

<?php echo $this->renderPartial('_form', array(
	'salePayment' => $salePayment,
    'saleInvoice' => $saleInvoice,
    'saleInvoiceDataProvider' => $saleInvoiceDataProvider,
)); ?>

