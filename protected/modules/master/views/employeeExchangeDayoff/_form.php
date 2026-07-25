<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $model EmployeeExchangeDayoff */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'employee-exchange-dayoff-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'employee_id'); ?>
        <?php echo CHtml::activeDropDownlist($model, 'employee_id', CHtml::listData(Employee::model()->findAllbyAttributes(array('status'=>'Active'), array('order' => 't.name ASC')), 'id','name'), array(
            'empty'=>'-- Pilih --',
            'onchange' => '
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlUpdateDateDayoffOld') . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#ajax-update").html(data);
                    },
                });
            ',
        )); ?>
        <?php echo $form->error($model, 'employee_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date_dayoff_new'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => "date_dayoff_new",
            // additional javascript options for the date picker plugin
            'options' => array(
                'minDate' => '-1W',
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
                'readOnly' => true,
            ),
            'htmlOptions' => array(
                'onchange' => '
                    $.ajax({
                        type: "POST",
                        url: "' . CController::createUrl('ajaxHtmlUpdateDateDayoffOld') . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#day-off-old-choice").html(data);
                        },
                    });
                '
            ),
        )); ?>
        <?php echo $form->error($model, 'date_dayoff_new'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date_dayoff_old'); ?>
        <div id="day-off-old-choice">
            <?php echo $this->renderPartial('_dateDayoffOld', array(
                'model' => $model,
                'dayOffOldList' => $dayOffOldList,
            )); ?>
        </div>
        <?php echo $form->error($model, 'date_dayoff_old'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->