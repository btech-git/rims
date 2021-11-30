<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    'Create',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'idempotent' => $idempotent,
        'model' => $model,
        'invoice' => $invoice,
    )); ?>
</div>