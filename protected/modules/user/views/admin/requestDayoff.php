<?php $this->breadcrumbs=array(
	'Employee Dayoffs'=>array('index'),
	'Request',
); ?>

<h1>Pengajuan Cuti Karyawan</h1>

<div id="maincontent">
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'employee-dayoff-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="medium-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($model, 'employee_id'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($model, 'employee_id'); ?>
                            <?php echo CHtml::encode(CHtml::value($model, 'employee.name')); ?>
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
                            <?php echo $form->labelEx($model, 'Mulai Tanggal'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $model,
                                'attribute' => "date_from",
                                // additional javascript options for the date picker plugin
                                'options' => array(
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

                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div><!-- form -->
</div>