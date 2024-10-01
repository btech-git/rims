<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Estimasi Penjualan'=>array('admin'),
	'Create',
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_list', array(
        'product' => $product, 
        'productDataProvider' => $productDataProvider, 
        'service' => $service,
        'serviceDataProvider' => $serviceDataProvider,
        'branches' => $branches,
        'endDate' => $endDate,
        'isSubmitted' => $isSubmitted,
    )); ?>
    
    <?php echo $this->renderPartial('_form', array(
        'saleEstimation' => $saleEstimation,
        'branches' => $branches,
        'isSubmitted' => $isSubmitted,
        'vehicle' => $vehicle,
        'vehicleDataProvider' => $vehicleDataProvider,
    )); ?>
</div>