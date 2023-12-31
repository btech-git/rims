<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs=array(
	'Payment Ins'=>array('index'),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List PaymentIn', 'url'=>array('index')),
	array('label'=>'Create PaymentIn', 'url'=>array('create')),
	array('label'=>'View PaymentIn', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PaymentIn', 'url'=>array('admin')),
);*/
?>

<h1>Update Payment In</h1>

<div id="maincontent">
    <?php $this->renderPartial('_formMultiple', array(
        'paymentIn' => $paymentIn,
        'customer' => $customer,
        'invoiceHeader' => $invoiceHeader,
        'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
    )); ?>
</div>