<?php
/* @var $this EmployeeDayoffController */
/* @var $model EmployeeDayoff */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'employee-dayoff-form',
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
                        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'employee_id',
                            'sourceUrl' => CController::createUrl('employeeCompletion'),
                            //additional javascript options for the autocomplete plugin
                            'options' => array(
                                'minLength' => '2',
                                'select' => 'js:function(event, ui) {
                                    $("#employee_name").html(ui.item.id);
                                }',
                            ),
                        )); ?>
                        
                        <?php echo CHtml::openTag('span', array('id' => 'employee_name')); ?>
                            <?php echo CHtml::encode(CHtml::value($model, 'employee.name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                        
                        <?php /*echo $form->hiddenField($model, 'employee_id'); ?>
                        <?php echo $form->textField($model, 'employee_name', array(
                            'onclick' => 'jQuery("#employee-dialog").dialog("open"); return false;',
                            'value' => $model->employee_id != Null ? $model->employee->name : '',
                        )); ?>

                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'employee-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Employee',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'employee-grid',
                            'dataProvider' => $employeeDataProvider,
                            'filter' => $employee,
                            // 'summaryText'=>'',
                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                            'pager' => array(
                                'cssFile' => false,
                                'header' => '',
                            ),
                            'selectionChanged' => 'js:function(id){
                                $("#EmployeeDayoff_employee_id").val($.fn.yiiGridView.getSelection(id));
                                $("#employee-dialog").dialog("close");
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxEmployee', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#EmployeeDayoff_employee_name").val(data.name);
                                    },
                                });

                                $("#employee-grid").find("tr.selected").each(function(){
                                    $(this).removeClass( "selected" );
                                });
                            }',
                            'columns' => array(
                                'id',
                                'code',
                                'name',
                            //'email',
                            ),
                        )); ?>
                        <?php $this->endWidget();*/ ?>

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
                        <?php echo $form->dropDownlist($model,'employee_onleave_category_id', CHtml::listData(EmployeeOnleaveCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih --')); ?>
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
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'onchange' => '
//                                    $("#EmployeeDayoff_day").val("");$("#EmployeeDayoff_date_to").val("");
                                    var strDateFrom = $("#EmployeeDayoff_date_from").val();
                                    var strDateTo = $("#EmployeeDayoff_date_to").val();
                                    var dateFrom = new Date(strDateFrom);
                                    var dateTo = new Date(strDateTo);
                                    var diff_in_time = dateTo.getTime() - dateFrom.getTime();
                                    var diff_in_days = diff_in_time / (1000 * 3600 * 24);
                                    $("#EmployeeDayoff_day").val(diff_in_days);
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
                        <?php //echo $form->textField($model, 'date_to', array('readonly' => true)); ?>
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
                                    var strDateFrom = $("#EmployeeDayoff_date_from").val();
                                    var strDateTo = $("#EmployeeDayoff_date_to").val();
                                    var dateFrom = new Date(strDateFrom);
                                    var dateTo = new Date(strDateTo);
                                    var diff_in_time = dateTo.getTime() - dateFrom.getTime();
                                    var diff_in_days = diff_in_time / (1000 * 3600 * 24);
                                    $("#EmployeeDayoff_day").val(diff_in_days);
                                '
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

                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->