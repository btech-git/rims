<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    'Create',
);
?>

<h1>Payment In</h1>

<div id="maincontent">
    <?php $this->renderPartial('_formMultiple', array(
        'paymentIn' => $paymentIn,
        'customer' => $customer,
        'invoiceHeader' => $invoiceHeader,
        'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
    )); ?>
</div>