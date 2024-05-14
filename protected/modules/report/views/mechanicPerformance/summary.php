<?php
Yii::app()->clientScript->registerScript('report', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $mechanicPerformanceSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($mechanicPerformanceSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
    $("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Jumlah per Halaman</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Mechanic</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($employee, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#employee-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#employee-dialog").dialog("open"); return false; }',
                                        )); ?>

                                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'employee-dialog',
                                            // additional javascript options for the dialog plugin
                                            'options' => array(
                                                'title' => 'Mekanik',
                                                'autoOpen' => false,
                                                'width' => 'auto',
                                                'modal' => true,
                                            ),
                                        )); ?>

                                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'employee-grid',
                                            'dataProvider' => $employeeDataProvider,
                                            'filter' => $employee,
                                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                            'pager'=>array(
                                               'cssFile'=>false,
                                               'header'=>'',
                                            ),
                                            'selectionChanged' => 'js:function(id){
                                                $("#' . CHtml::activeId($employee, 'id') . '").val($.fn.yiiGridView.getSelection(id));
                                                $("#employee-dialog").dialog("close");
                                                if ($.fn.yiiGridView.getSelection(id) == "") {
                                                    $("#employee_name").html("");
                                                } else {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "JSON",
                                                        url: "' . CController::createUrl('ajaxJsonEmployee') . '",
                                                        data: $("form").serialize(),
                                                        success: function(data) {
                                                            $("#employee_name").html(data.employee_name);
                                                        },
                                                    });
                                                }
                                            }',
                                            'columns' => array(
                                                'name',
                                                array(
                                                    'name' => 'email',
                                                    'value' => 'CHtml::encode(CHtml::value($data, "email"))',
                                                ),
                                                array(
                                                    'name' => 'id_card',
                                                    'filter' => false,
                                                    'value' => '$data->id_card',
                                                ),
                                                array(
                                                    'name' => 'skills',
                                                    'filter' => false,
                                                    'value' => '$data->skills',
                                                ),
                                            ),
                                        )); ?>
                                        <?php $this->endWidget(); ?>
                                        <?php echo CHtml::openTag('span', array('id' => 'employee_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="medium-12 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-5 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'StartDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Mulai',
                                            ),
                                        )); ?>
                                    </div>

                                    <div class="small-5 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'EndDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Sampai',
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <div class="reportDisplay">
                        <?php echo ReportHelper::summaryText($mechanicPerformanceSummary->dataProvider); ?>
                        <?php //echo ReportHelper::sortText($mechanicPerformanceSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                    </div>
                    
                    <?php $this->renderPartial('_summary', array(
                        'employee' => $employee,
                        'mechanicPerformanceSummary' => $mechanicPerformanceSummary,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<br/>

<div class="right">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $mechanicPerformanceSummary->dataProvider->pagination->itemCount,
        'pageSize' => $mechanicPerformanceSummary->dataProvider->pagination->pageSize,
        'currentPage' => $mechanicPerformanceSummary->dataProvider->pagination->getCurrentPage(false),
    )); ?>
</div>
<div class="clear"></div>