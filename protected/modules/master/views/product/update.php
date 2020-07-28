<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Product'=>array('admin'),
	'Products'=>array('admin'),
	//$product->header->name=>array('view','id'=>$product->header->id),
	'Update Product',
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'View Product', 'url'=>array('view', 'id'=>$product->header->id)),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('product'=>$product,'productSpecificationBattery'=>$productSpecificationBattery, 'productSpecificationOil'=>$productSpecificationOil, 'productSpecificationTire'=>$productSpecificationTire,'supplier'=>$supplier,'supplierDataProvider'=>$supplierDataProvider,'unit'=>$unit,'unitDataProvider'=>$unitDataProvider,'productComplementSubstitute'=>$productComplementSubstitute,'productComplementSubstituteDataProvider'=>$productComplementSubstituteDataProvider)); ?>
		</div>