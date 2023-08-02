<?php
/* @var $this EmployeeTimesheetController */
/* @var $model EmployeeTimesheet */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'employee-timesheet-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'employee_id'); ?>
        <?php echo CHtml::activeDropDownList($model, 'employee_id', CHtml::listData(Employee::model()->findAll(array('condition' => 'status = "Active"', 'order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Pilih Employee --')); ?>
        <?php echo $form->error($model, 'employee_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model' => $model,
            'attribute' => "date",
            'options'=>array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth'=>true,
                'changeYear'=>true,
            ),
            'htmlOptions'=>array(
                'value'=>date('Y-m-d'),
                'readonly' => true,
            ),
        )); ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'clock_in'); ?>
        <?php echo $form->textField($model, 'clock_in'); ?>
        <?php echo $form->error($model, 'clock_in'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'clock_out'); ?>
        <?php echo $form->textField($model, 'clock_out'); ?>
        <?php echo $form->error($model, 'clock_out'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->