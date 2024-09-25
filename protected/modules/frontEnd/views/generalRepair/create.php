<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'General Repair Registration'=>array('admin'),
	'Create',
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'generalRepair' => $generalRepair,
        'vehicle' => $vehicle,
        'customer' => $customer,
    )); ?>
</div>