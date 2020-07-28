<?php
/* @var $this ConsignmentInHeaderController */
/* @var $model ConsignmentInHeader */

$this->breadcrumbs = array(
    'Consignment In Headers' => array('admin'),
    'Create',
);

$this->menu = array(
    array('label' => 'List ConsignmentInHeader', 'url' => array('index')),
    array('label' => 'Manage ConsignmentInHeader', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        //'model'=>$model
        'consignmentIn' => $consignmentIn,
        'supplier' => $supplier,
        'supplierDataProvider' => $supplierDataProvider,
        'product' => $product,
        'productDataProvider' => $productDataProvider,
    )); ?>
</div>


