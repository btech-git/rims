<?php
/* @var $this SupplierController */
/* @var $model Supplier */

$this->breadcrumbs=array(
 	'Company',
 	'Suppliers'=>array('admin'),
 	'Create',
 );

// $this->menu=array(
// 	array('label'=>'List Supplier', 'url'=>array('index')),
// 	array('label'=>'Manage Supplier', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('supplier'=>$supplier,
		'bank'=>$bank,
		'bankDataProvider'=>$bankDataProvider,
		'product'=>$product,
		'productDataProvider'=>$productDataProvider,
		'productArray'=>$productArray,
		'coa'=>$coa,
		'coaDataProvider'=>$coaDataProvider,
		'coaOutstanding'=>$coaOutstanding,
		'coaOutstandingDataProvider'=>$coaOutstandingDataProvider,
	)); ?>
</div>