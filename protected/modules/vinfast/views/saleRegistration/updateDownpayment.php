<?php
/* @var $this RegistrationTransactionController */
/* @var $generalRepairRegistration->header RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    $generalRepairRegistration->header->id,
);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'downpayment-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'enableAjaxValidation'=>false,
)); ?>
            <?php echo $form->errorSummary($generalRepairRegistration->header); ?>
<div class="small-12 columns">
    <?php echo $this->renderPartial('_formDownpayment', array(
        'generalRepairRegistration' => $generalRepairRegistration,
        'vehicle' => $vehicle,
        'customer' => $customer,
        'services' => $services,
        'products' => $products,
    )); ?>
</div>

<?php $this->endWidget(); ?>