<?php
/* @var $this EmployeeDayoffController */
/* @var $model EmployeeDayoff */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'employee-dayoff-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'employee_id'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($model, 'employee_id'); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'EmployeeName',
                            'value' => CHtml::value($model, 'employee.name'),
                            'sourceUrl' => CController::createUrl('employeeCompletion'),
                            //additional javascript options for the autocomplete plugin
                            'options' => array(
                                'minLength' => '2',
                                'select' => 'js:function(event, ui) {
                                    $("#' . CHtml::activeId($model, 'employee_id') . '").val(ui.item.id);
                                }',
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'employee_id'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model,'Jenis Cuti'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $employeeOnleaveCategories = EmployeeOnleaveCategory::model()->findAllByAttributes(array('is_inactive' => 0)); ?>
                        <?php $employeeOnleaveCategoryChoiceOptions = array(); ?>
                        <?php foreach ($employeeOnleaveCategories as $employeeOnleaveCategory): ?>
                            <?php $employeeOnleaveCategoryChoiceOptions[$employeeOnleaveCategory->id] = array('data-number-of-leave-day' => $employeeOnleaveCategory->number_of_days); ?>
                        <?php endforeach; ?>
                        
                        <?php echo $form->dropDownlist($model, 'employee_onleave_category_id', CHtml::listData($employeeOnleaveCategories, 'id', 'nameAndDays'), array(
                            'empty' => '-- Pilih --',
                            'options' => $employeeOnleaveCategoryChoiceOptions,
                            'onchange' => '
                                var numberOfLeaveDayString = $("option[value=" + $(this).val() + "]", this).attr("data-number-of-leave-day");
                                $("#' . CHtml::activeId($model, 'day') . '").val(numberOfLeaveDayString);
                                if (numberOfLeaveDayString === "0") {
                                    $("#' . CHtml::activeId($model, 'date_to') . '").prop("readonly", false);
                                    $("#' . CHtml::activeId($model, 'date_to') . '").show();
                                    $("#DateTo").hide();
                                } else {
                                    $("#' . CHtml::activeId($model, 'date_to') . '").prop("readonly", true);
                                    $("#' . CHtml::activeId($model, 'date_to') . '").hide();
                                    $("#DateTo").show();
                                    var dateFromString = $("#' . CHtml::activeId($model, 'date_from') . '").val();
                                    var dateTo = new Date(dateFromString);
                                    dateTo.setDate(dateTo.getDate() + parseInt(numberOfLeaveDayString) - 1);
                                    var dateToString = dateTo.toISOString().slice(0, 10);
                                    $("#' . CHtml::activeId($model, 'date_to') . '").val(dateToString);
                                    $("#DateTo").val(dateToString);
                                }
                            '
                        )); ?>
                        <?php echo $form->error($model,'employee_onleave_category_id'); ?>
                    </div>
                </div>
            </div>	
        
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Paid/Unpaid'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //$range = range(1, 20); ?>
                        <?php echo $form->dropDownList($model, 'off_type', array(
                            'Paid' => 'Paid', 
                            'Unpaid' => 'Unpaid'
                        ), array(
                            'prompt' => '[--Select off Type--]',
                        )); ?>
                        <?php //echo $form->textField($model,'day');  ?>
                        <?php echo $form->error($model, 'off_type'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Mulai Tanggal'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => "date_from",
                            // additional javascript options for the date picker plugin
                            'options' => array(
                                'minDate' => '-1W',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'onchange' => '
                                    var employeeOnleaveCategoryElement = $("#' . CHtml::activeId($model, 'employee_onleave_category_id') . '");
                                    var categoryId = employeeOnleaveCategoryElement.val();
                                    var numberOfLeaveDayString = $("option[value=\'" + categoryId + "\']", employeeOnleaveCategoryElement).attr("data-number-of-leave-day");
                                    if (numberOfLeaveDayString === "0") {
                                        var strDateFrom = $(this).val();
                                        var strDateTo = $("#' . CHtml::activeId($model, 'date_to') . '").val();
                                        var dateFrom = new Date(strDateFrom);
                                        var dateTo = new Date(strDateTo);
                                        var diffInTime = dateTo.getTime() - dateFrom.getTime();
                                        var diffInDays = diffInTime / (1000 * 3600 * 24) + 1;
                                        $("#EmployeeDayoff_day").val(diffInDays);
                                    } else {
                                        var dateFromString = $("#' . CHtml::activeId($model, 'date_from') . '").val();
                                        var dateTo = new Date(dateFromString);
                                        dateTo.setDate(dateTo.getDate() + parseInt(numberOfLeaveDayString) - 1);
                                        var dateToString = dateTo.toISOString().slice(0, 10);
                                        $("#' . CHtml::activeId($model, 'date_to') . '").val(dateToString);
                                        $("#DateTo").val(dateToString);
                                    }
                                '
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'date_from'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Sampai Tanggal'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('DateTo', $model->date_to, array('readonly' => true, 'style' => 'display: ' . ($model->employeeOnleaveCategory !== null && (int) $model->employeeOnleaveCategory->number_of_days > 0 ? 'block' : 'none'))); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => "date_to",
                            // additional javascript options for the date picker plugin
                            'options' => array(
                                'minDate' => '-1W',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'onchange' => '
                                    var strDateFrom = $("#' . CHtml::activeId($model, 'date_from') . '").val();
                                    var strDateTo = $(this).val();
                                    var dateFrom = new Date(strDateFrom);
                                    var dateTo = new Date(strDateTo);
                                    var diffInTime = dateTo.getTime() - dateFrom.getTime();
                                    var diffInDays = diffInTime / (1000 * 3600 * 24) + 1;
                                    $("#EmployeeDayoff_day").val(diffInDays);
                                ',
                                'style' => 'display: ' . ($model->employeeOnleaveCategory !== null && (int) $model->employeeOnleaveCategory->number_of_days === 0 ? 'block' : 'none'),
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'date_to'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'Jumlah Hari'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php /*$range = range(1, 20); ?>
                        <?php echo $form->dropDownList($model, 'day', array_combine($range, $range), array(
                            'prompt' => '[--Select Days--]',
                            'onchange' => '
                                var strDate = $("#EmployeeDayoff_date_from").val();
                                var datepo = new Date(strDate);
                                var days = +$(this).val();
                                datepo.setDate(datepo.getDate() + days);
                                var strFormatedPODate = $.datepicker.formatDate("yy-m-d", new Date(datepo)); 
                                //console.log(strDate);
                                $("#EmployeeDayoff_date_to").val(strFormatedPODate);
                            '
                        ));*/ ?>
                        <?php echo $form->textField($model, 'day', array('readonly' => true));  ?>
                        <?php echo $form->error($model, 'day'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'notes'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model, 'notes', array('rows' => 6, 'cols' => 50)); ?>
                        <?php echo $form->error($model, 'notes'); ?>
                    </div>
                </div>
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

            <div class="field buttons text-center">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->