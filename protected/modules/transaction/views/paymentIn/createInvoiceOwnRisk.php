<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    'Create',
);
?>

<h1>Payment In Insurance Own Risk (OR)</h1>

<div id="maincontent">
    <?php $this->renderPartial('_formMultiple', array(
        'paymentIn' => $paymentIn,
    )); ?>
</div>