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
        'registrationTransaction' => $registrationTransaction,
        'customer' => $customer,
        'vehicle' => $vehicle,
    )); ?>
</div>