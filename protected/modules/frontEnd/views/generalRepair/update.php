<?php
/* @var $this RegistrationTransactionController */
/* @var $generalRepair->header RegistrationTransaction */

$this->breadcrumbs=array(
	'Registration Transactions'=>array('admin'),
	$generalRepair->header->id=>array('view','id'=>$generalRepair->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RegistrationTransaction', 'url'=>array('index')),
	array('label'=>'Create RegistrationTransaction', 'url'=>array('create')),
	array('label'=>'View RegistrationTransaction', 'url'=>array('view', 'id'=>$generalRepair->header->id)),
	array('label'=>'Manage RegistrationTransaction', 'url'=>array('admin')),
);
?>


<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'generalRepair' => $generalRepair,
        'vehicle' => $vehicle,
        'customer' => $customer,
    )); ?>
</div>
	