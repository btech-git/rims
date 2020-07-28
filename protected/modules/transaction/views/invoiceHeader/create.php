<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs=array(
	'Invoice Headers'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List InvoiceHeader', 'url'=>array('index')),
	array('label'=>'Manage InvoiceHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create InvoiceHeader</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('invoice'=>$invoice)); ?></div>