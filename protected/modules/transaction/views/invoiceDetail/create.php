<?php
/* @var $this InvoiceDetailController */
/* @var $model InvoiceDetail */

$this->breadcrumbs=array(
	'Invoice Details'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List InvoiceDetail', 'url'=>array('index')),
	array('label'=>'Manage InvoiceDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create InvoiceDetail</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>