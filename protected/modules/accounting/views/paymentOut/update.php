<?php $this->breadcrumbs = array(
    'Purchase Payment'=>array('update'),
    'Update',
); ?>

<h1>Revisi Pembayaran Pembelian Barang</h1>

<?php echo $this->renderPartial('_form', array(
    'paymentOut' => $paymentOut,
    'purchaseOrder' => $purchaseOrder,
    'receiveItem' => $receiveItem,
    'receiveItemDataProvider' => $receiveItemDataProvider,
)); ?>

