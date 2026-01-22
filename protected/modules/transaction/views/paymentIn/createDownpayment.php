<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    'Create',
);
?>

<h1>Payment In DP</h1>

<div id="maincontent">
    <?php $this->renderPartial('_formDownpayment', array(
        'paymentIn' => $paymentIn,
    )); ?>
</div>