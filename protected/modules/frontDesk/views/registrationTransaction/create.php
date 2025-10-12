<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/registrationTransaction/admin';?>">
            <span class="fa fa-th-list"></span>Manage
        </a>
        
        <h1>New Registration Transaction</h1>
        
        <?php echo $this->renderPartial('_form', array(
            'registrationTransaction' => $registrationTransaction,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'vehicleData' => $vehicleData,
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'customer' => $customer,
        )); ?>
    </div>
</div>