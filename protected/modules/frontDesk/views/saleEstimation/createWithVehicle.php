<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Estimasi Penjualan'=>array('admin'),
	'Create',
);
?>
<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Create Estimasi Penjualan</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php echo CHtml::link('Manage', array("admin"), array('class' => 'btn btn-info btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

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
        'branches' => $branches,
        'isSubmitted' => $isSubmitted,
        'vehicleId' => $vehicleId,
        'vehicle' => $vehicle,
        'customer' => $customer,
        'branch' => $branch,
    )); ?>
</div>