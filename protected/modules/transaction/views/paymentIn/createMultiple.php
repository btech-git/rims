<?php $this->breadcrumbs = array(
    'Payment In'=>array('admin'),
    'Create',
); ?>

<h1>Payment In</h1>

<?php echo $this->renderPartial('_formMultiple', array(
    'paymentIn' => $paymentIn,
    'invoiceHeader' => $invoiceHeader,
    'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
)); ?>

