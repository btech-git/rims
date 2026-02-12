<?php
Yii::app()->clientScript->registerScript('report', '
    $(".breadcrumbs").addClass("hide");
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Plate #</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('PlateNumber', $plateNumber); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">WO #</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('WorkOrderNumber', $workOrderNumber); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Car Make</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('CarMakeId', $carMakeId, CHtml::listData(VehicleCarMake::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                        'onchange' => 
                                            CHtml::ajax(array(
                                            'type' => 'GET',
                                            'url' => CController::createUrl('ajaxHtmlUpdateCarModelSelect'),
                                            'update' => '#car_model',
                                        )),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Car Model</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('CarModelId', $carModelId, CHtml::listData(VehicleCarModel::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                                        'empty' => '-- All --',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Type</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('RepairType', $repairType, array(
                                        ''=>'-- All --',
                                        'GR'=>'GR',
                                        'BR'=>'BR',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">WO Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownList('TransactionStatus', $transactionStatus, array(
                                        ''=>'-- All --',
                                        'Waitlist'=>'Waitlist',
                                        'Processing WO'=>'Processing WO',
                                        'Assigned'=>'Assigned',
                                        'Finished'=>'Finished',
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Tanggal</span>
                                </div>
                                <div class="small-4 columns">
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
                                <div class="small-4 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'EndDate',
                                        'options' => array(
                                            'dateFormat' => 'yy-mm-dd',
                                            'changeMonth'=>true,
                                            'changeYear'=>true,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'placeholder' => 'Akhir',
                                        ),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
                
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                
                <div class="clear"></div>
            </div>

            <hr />

            <div class="right"><?php //echo ReportHelper::summaryText($workOrderSummary->dataProvider); ?></div>
            <div class="clear"></div>
            
            <br />

            <div class="relative">
                <div style="font-weight: bold; text-align: center">
                    <div style="font-size: larger">Raperind Motor</div>
                    <div style="font-size: larger">Work Order</div>
                    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
                </div>

                <br />

                <div style="width: 3000px">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => $detailTabs,
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>
                </div>
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
</div>