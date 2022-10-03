<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs = array(
    'Company',
    'Employees' => array('admin'),
    //$model->name=>array('view','id'=>$model->id),
    'Update Employee',
);
?>

<div id="maincontent">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'customer-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            //'enableAjaxValidation'=>false,
    )); ?>

    <?php $this->renderPartial('_form', array(
        'employee' => $employee, 
        'bank' => $bank,
        'bankDataProvider' => $bankDataProvider,
        'incentive' => $incentive,
        'incentiveDataProvider' => $incentiveDataProvider,
        'deduction' => $deduction,
        'deductionDataProvider' => $deductionDataProvider,
    )); ?>
<?php $this->endWidget(); ?>
</div>