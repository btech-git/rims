<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */

$this->breadcrumbs = array(
    'Registration Transactions' => array('admin'),
    'Manage',
);
?>

<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Manage Estimasi</h4>
    </div>
    <div class="col d-flex justify-content-end">
        <div class="d-gap">
            <?php //echo CHtml::link('Add', array("create"), array('class' => 'btn btn-success btn-sm')); ?>
        </div>
    </div>
</div>

<hr />

<div id="sale_estimation_data_container">
    <?php $this->renderPartial('_saleEstimationDataTable', array(
        'model' => $model,
        'dataProvider' => $dataProvider,
        'customerName' => $customerName,
        'plateNumber' => $plateNumber,
    )); ?>
</div>
