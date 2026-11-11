<?php
Yii::app()->clientScript->registerScript('report', '
    $(".breadcrumbs").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

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

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Customer</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropdownList('CustomerId', $customerId, CHtml::listData(Customer::model()->findAll(array(
                                        'condition' => 't.id IN (60849, 60926, 63482)',
                                        'order' => 't.name ASC'
                                    )), 'id', 'name'), array('empty' => '-- All --',)); ?>
                                </div>
                            </div>
                        </div>
                        
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

                <div class="clear"></div>
                
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcelOutstanding')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                
                <div class="clear"></div>
            </div>

            <hr />

            <div class="relative">
                <div style="font-weight: bold; text-align: center">
                    <div style="font-size: larger">Raperind Motor</div>
                    <div style="font-size: larger">Outstanding Work Order (Pending Invoices)</div>
                    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(date('Y-m-d')))); ?></div>
                </div>

                <br />

                <div class="table_wrapper">
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