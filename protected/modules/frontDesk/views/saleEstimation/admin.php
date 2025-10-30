<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */

$this->breadcrumbs = array(
    'Registration Transactions' => array('admin'),
    'Manage',
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php echo CHtml::link('Add', array("create"), array(
            'class' => 'button success right', 
            'style' => 'margin-right:10px',
            'target' =>'_blank',
        )); ?>
        <h1>Manage Estimasi</h1>

        <div class="grid-view">
            <?php $this->renderPartial('_saleEstimationDataTable', array(
                'model' => $model,
                'dataProvider' => $dataProvider,
                'customerName' => $customerName,
                'plateNumber' => $plateNumber,
            )); ?>
        </div>
    </div>
</div>
