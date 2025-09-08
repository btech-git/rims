<?php
/* @var $this EmployeeTimesheetController */
/* @var $model EmployeeTimesheet */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'employee-timesheet-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
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

    <div class="row">
        <?php echo $form->labelEx($model, 'remarks'); ?>
        <?php echo $form->textField($model, 'remarks'); ?>
        <?php echo $form->error($model, 'remarks'); ?>
    </div>

    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <?php echo CHtml::label('Attach Images (Upload size max 2MB)', ''); ?>
            </div>
            <div class="small-8 columns">
                <?php $this->widget('CMultiFileUpload', array(
                    'model' => $model,
                    'attribute' => 'images',
                    'accept' => 'jpg|jpeg|png|gif',
                    'denied' => 'Only jpg, jpeg, png and gif are allowed',
                    'max' => 10,
                    'remove' => '[x]',
                    'duplicate' => 'Already Selected',
                    'options' => array(
                        'afterFileSelect' => 'function(e ,v ,m){
                            var fileSize = e.files[0].size;
                            if (fileSize > 2*1024*1024) {
                                alert("Exceeds file upload limit 2MB");
                                $(".MultiFile-remove").click();
                            }                      
                            return true;
                        }',
                    ),
                )); ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->