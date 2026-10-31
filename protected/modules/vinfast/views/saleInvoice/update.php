<?php

$this->breadcrumbs=array(
	'Invoice Headers'=>array('admin'),
	$invoice->header->id=>array('view','id'=>$invoice->header->id),
	'Update',
);
?>

<h1>Update Invoice #<?php echo $invoice->header->id; ?></h1>

<div id="maincontent">
    <?php $this->renderPartial('_form', array('invoice'=>$invoice)); ?>
</div>