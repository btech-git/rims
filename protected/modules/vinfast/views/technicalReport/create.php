<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs=array(
	'Estimasi Penjualan'=>array('admin'),
	'Create',
);
?>
<div class="row d-print-none">
    <div class="col d-flex justify-content-start">
        <h4>Create Technical Report</h4>
        <?php echo CHtml::link('Manage', array("admin"), array(
            'class'=> 'button cbutton right', 
            'style' => 'margin-right:10px',
        )); ?>
    </div>
</div>

<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'technicalReport' => $technicalReport,
    )); ?>
</div>