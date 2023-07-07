<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs=array(
	'Invoice Headers'=>array('admin'),
	'Create',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'invoice' => $invoice,
    )); ?>
</div>