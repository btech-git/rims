<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Product'=>array('admin'),
	'Products'=>array('admin'),
	'Create',
); ?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'product'=>$product, 
        'productSpecificationBattery'=>$productSpecificationBattery, 
        'productSpecificationOil'=>$productSpecificationOil, 
        'productSpecificationTire'=>$productSpecificationTire,
        'supplier'=>$supplier,
        'supplierDataProvider'=>$supplierDataProvider,
        'unit'=>$unit,
        'unitDataProvider'=>$unitDataProvider,
        'productComplementSubstitute'=>$productComplementSubstitute,
        'productComplementSubstituteDataProvider'=>$productComplementSubstituteDataProvider
    )); ?>
</div>