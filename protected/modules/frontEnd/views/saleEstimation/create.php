<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Estimasi Penjualan'=>array('admin'),
	'Create',
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_listProduct', array(
        'product' => $product, 
        'productDataProvider' => $productDataProvider, 
            'branches' => $branches,
            'endDate' => $endDate,
    )); ?>
    <?php echo $this->renderPartial('_listService', array(
        'service' => $service,
        'serviceDataProvider' => $serviceDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
    )); ?>
    <?php echo $this->renderPartial('_form', array(
        'saleEstimation' => $saleEstimation,
    )); ?>
</div>