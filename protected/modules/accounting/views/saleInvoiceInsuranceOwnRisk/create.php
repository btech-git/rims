<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs=array(
	'Invoice OR'=>array('admin'),
	'Create',
);
?>

<h1>Create Invoice Own Risk</h1>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'saleInvoice' => $saleInvoice,
        'registrationTransaction' => $registrationTransaction,
    )); ?>
</div>