<?php
Yii::app()->clientScript->registerScript('report', '

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $workOrderVehicleSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($workOrderVehicleSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                        <span class="prefix">Vehicle</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($vehicle, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#vehicle-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#vehicle-dialog").dialog("open"); return false; }',
                                        )); ?>

                                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'vehicle-dialog',
                                            'options' => array(
                                                'title' => 'Vehicle',
                                                'autoOpen' => false,
                                                'width' => 'auto',
                                                'modal' => true,
                                            ),
                                        )); ?>

                                        <div class="row">
                                            <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
                                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                                    'id'=>'vehicle-grid',
                                                    'dataProvider'=>$vehicleDataProvider,
                                                    'filter'=>$vehicle,
                                                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                                    'pager'=>array(
                                                        'cssFile'=>false,
                                                        'header'=>'',
                                                    ),
                                                    'selectionChanged'=>'js:function(id){
                                                        $("#' . CHtml::activeId($vehicle, 'id') . '").val($.fn.yiiGridView.getSelection(id));
                                                        $("#vehicle-dialog").dialog("close");
                                                        if ($.fn.yiiGridView.getSelection(id) == "") {
                                                            $("#vehicle_name").html("");
                                                        } else {
                                                            $.ajax({
                                                                type: "POST",
                                                                dataType: "JSON",
                                                                url: "' . CController::createUrl('ajaxJsonVehicle') . '",
                                                                data: $("form").serialize(),
                                                                success: function(data) {
                                                                    $("#vehicle_name").html(data.vehicle_name);
                                                                },
                                                            });
                                                        }
                                                    }',
                                                    'columns'=>array(
                                                        'carMake.name',
                                                        'carModel.name',
                                                        'carSubModel.name',
                                                        'plate_number',
                                                        'customer.name',
//                                                        array(
//                                                            'name' => 'service_category_id',
//                                                            'value' => '$data->serviceCategory->name',
//                                                        ),
//                                                        array(
//                                                            'name' => 'service_type_id',
//                                                            'value' => '$data->serviceType->name',
//                                                        ),
                                                    ),
                                                )); ?>
                                            </div>
                                        </div>
                                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                                        <?php echo CHtml::openTag('span', array('id' => 'vehicle_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($vehicle, 'name')); ?>
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
                                        <span class="prefix">Periode:</span>
                                    </div>
                                    
                                    <div class="small-5 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'StartDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
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
                        <?php echo CHtml::resetButton('Hapus');  ?>
                        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>
                </div>

                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'workOrderVehicleSummary' => $workOrderVehicleSummary,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>