<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs = array(
    'Company',
    'Customers' => array('admin'),
    //$model->name=>array('view','id'=>$model->id),
    'Update Customer',
);
?>

<div id="maincontent">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'customer-form',
    )); ?>
    <?php if ($this->action->id == 'updatePic') { ?>
        <?php $this->renderPartial('_updatePic', array('model' => $model)); ?>
    <?php } elseif ($this->action->id == 'updateVehicle') { ?>
        <?php $this->renderPartial('_updateVehicle', array('model' => $model)); ?>
    <?php } elseif ($this->action->id == 'updatePrice') { ?>
        <?php $this->renderPartial('_updatePrice', array('model' => $model)); ?>
    <?php } else { ?>
        <?php $this->renderPartial('_form', array(
            'customer' => $customer, 
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider, 
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
        )); ?>
    <?php } ?>

<?php $this->endWidget(); ?>
</div>