<?php
/* @var $this RegistrationTransactionController */
/* @var $generalRepairRegistration->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	$generalRepairRegistration->header->id=>array('view','id'=>$generalRepairRegistration->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$generalRepairRegistration->header->id)),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>


<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'generalRepairRegistration' => $generalRepairRegistration,
        'vehicle' => $vehicle,
        'customer' => $customer,
        'generalRepairDate' => $generalRepairDate,
        'generalRepairHour' => $generalRepairHour,
        'generalRepairMinute' => $generalRepairMinute,
    )); ?>
</div>
	