<?php
/* @var $this RegistrationTransactionController */
/* @var $generalRepairRegistration->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Estimasi Penjualan'=>array('admin'),
	$saleEstimation->header->id=>array('view','id'=>$saleEstimation->header->id),
	'Update',
);
?>

<div id="maincontent">
    <?php echo $this->renderPartial('_list', array(
        'saleEstimation' => $saleEstimation,
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
        'customerName' => $customerName,
        'branches' => $branches,
        'branch' => $branch,
        'isSubmitted' => $isSubmitted,
        'vehicleData' => $vehicleData,
        'vehicleDataProvider' => $vehicleDataProvider,
        'product' => $product, 
        'productDataProvider' => $productDataProvider, 
        'service' => $service,
        'serviceDataProvider' => $serviceDataProvider,
    )); ?>
</div>
	