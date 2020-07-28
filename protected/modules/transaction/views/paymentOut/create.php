<?php
/* @var $this PaymentOutController */
/* @var $model PaymentOut */

$this->breadcrumbs = array(
    'Payment Outs' => array('index'),
    'Create',
);

/*$this->menu=array(
	array('label'=>'List PaymentOut', 'url'=>array('index')),
	array('label'=>'Manage PaymentOut', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create PaymentOut</h1>-->

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'model' => $model,
        'purchaseOrder' => $purchaseOrder,
        'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
    )); ?></div>