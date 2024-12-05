<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs = array(
    'Product' => array('admin'),
    'Products' => array('admin'),
    //$product->header->name=>array('view','id'=>$product->header->id),
    'Update Product',
);

?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'product' => $product, 
        'productSpecificationBattery' => $productSpecificationBattery, 
        'productSpecificationOil' => $productSpecificationOil, 
        'productSpecificationTire' => $productSpecificationTire, 
        'supplier' => $supplier, 
        'supplierDataProvider' => $supplierDataProvider, 
        'unit' => $unit, 
        'unitDataProvider' => $unitDataProvider, 
        'productComplementSubstitute' => $productComplementSubstitute, 
        'productComplementSubstituteDataProvider' => $productComplementSubstituteDataProvider
    )); ?>
</div>