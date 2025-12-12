<?php
/* @var $this RegistrationTransactionController */
/* @var $bodyRepairRegistration->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	$bodyRepairRegistration->header->id=>array('view','id'=>$bodyRepairRegistration->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$bodyRepairRegistration->header->id)),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>


<div id="maincontent">
	<?php echo $this->renderPartial('_form', array(
        'bodyRepairRegistration' => $bodyRepairRegistration,
        'vehicle' => $vehicle,
        'customer' => $customer,
        'bodyRepairDate' => $bodyRepairDate,
        'bodyRepairHour' => $bodyRepairHour,
        'bodyRepairMinute' => $bodyRepairMinute,
    )); ?>
</div>
	