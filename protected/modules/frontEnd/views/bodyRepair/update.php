<?php
/* @var $this RegistrationTransactionController */
/* @var $bodyRepair->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	$bodyRepair->header->id=>array('view','id'=>$bodyRepair->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$bodyRepair->header->id)),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>


<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(
        'bodyRepair' => $bodyRepair,
        'vehicle' => $vehicle,
        'customer' => $customer,
//        'damage' => $damage,
//        'damageDataProvider' =>$damageDataProvider,
//        'qs' => $qs,
//        'qsDataProvider' => $qsDataProvider,
//        'service' => $service,
//        'serviceDataProvider' => $serviceDataProvider,
//        'product' => $product,
//        'productDataProvider' => $productDataProvider,
//        'serviceArray' => $serviceArray,
//        'type' => $type,
    )); ?>
</div>
	