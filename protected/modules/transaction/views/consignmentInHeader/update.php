<?php
/* @var $this ConsignmentInHeaderController */
/* @var $model ConsignmentInHeader */

$this->breadcrumbs=array(
	'Consignment In Headers'=>array('admin'),
	$consignmentIn->header->id=>array('view','id'=>$consignmentIn->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConsignmentInHeader', 'url'=>array('index')),
	array('label'=>'Create ConsignmentInHeader', 'url'=>array('create')),
	array('label'=>'View ConsignmentInHeader', 'url'=>array('view', 'id'=>$consignmentIn->header->id)),
	array('label'=>'Manage ConsignmentInHeader', 'url'=>array('admin')),
);
?>

<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(
			//'model'=>$model
			'consignmentIn'=>$consignmentIn,
			'supplier'=>$supplier,
			'supplierDataProvider'=>$supplierDataProvider,
			'product'=>$product,
			'productDataProvider'=>$productDataProvider,
			)); ?>
</div>
