<?php
$this->breadcrumbs=array(
	'Invoice OR'=>array('admin'),
	$saleInvoice->id=>array('view','id'=>$saleInvoice->id),
	'Update',
);
?>

<h1>Update Invoice OR #<?php echo $saleInvoice->id; ?></h1>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'saleInvoice' => $saleInvoice,
        'registrationTransaction' => $registrationTransaction,
    )); ?>
</div>