<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Body Repair Registration'=>array('admin'),
	'Create',
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