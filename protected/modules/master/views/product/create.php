<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Product'=>array('admin'),
	'Products'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);*/
?>



<div id="maincontent">
    <?php $this->renderPartial('_form', array('product'=>$product, 'productSpecificationBattery'=>$productSpecificationBattery, 'productSpecificationOil'=>$productSpecificationOil, 'productSpecificationTire'=>$productSpecificationTire,'supplier'=>$supplier,'supplierDataProvider'=>$supplierDataProvider,'unit'=>$unit,'unitDataProvider'=>$unitDataProvider,'productComplementSubstitute'=>$productComplementSubstitute,'productComplementSubstituteDataProvider'=>$productComplementSubstituteDataProvider)); ?>
</div>