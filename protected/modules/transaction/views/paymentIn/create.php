<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs=array(
	'Payment Ins'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List PaymentIn', 'url'=>array('index')),
	array('label'=>'Manage PaymentIn', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create PaymentIn</h1>-->

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'model'=>$model,
        'invoice'=>$invoice,
//		'invoiceDataProvider'=>$invoiceDataProvider,
    )); ?>
</div>