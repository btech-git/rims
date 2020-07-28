<?php
/* @var $this InvoiceHeaderController */
/* @var $invoice->header InvoiceHeader */

$this->breadcrumbs=array(
	'Invoice Headers'=>array('admin'),
	$invoice->header->id=>array('view','id'=>$invoice->header->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List InvoiceHeader', 'url'=>array('index')),
	array('label'=>'Create InvoiceHeader', 'url'=>array('create')),
	array('label'=>'View InvoiceHeader', 'url'=>array('view', 'id'=>$invoice->header->id)),
	array('label'=>'Manage InvoiceHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update InvoiceHeader <?php echo $invoice->header->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('invoice'=>$invoice)); ?></div>