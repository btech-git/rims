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
        'vehicle' => $vehicle,
        'vehicleData' => $vehicleData,
        'vehicleDataProvider' => $vehicleDataProvider,
        'customer' => $customer,
        'customerName' => $customerName,
        'branches' => $branches,
        'isSubmitted' => $isSubmitted,
        'branch' => $branch,
    )); ?>
</div>
	