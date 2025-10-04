<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */

$this->breadcrumbs = array(
    'Vehicle' => array('admin'),
    'Manage',
);
?>

<div class="tab reportTab">
    <div class="tabHead"><h4>Kendaraan Keluar / Masuk Bengkel</h4></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Customer</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('CustomerName', $customerName, array(
                                        'class' => 'form-select',
//                                        'onchange' => CHtml::ajax(array(
//                                            'type' => 'GET',
//                                            'url' => CController::createUrl('ajaxHtmlUpdateVehicleEntryDataTable'),
//                                            'update' => '#vehicle_entry_status_data_container',
//                                        )) . 
//                                        CHtml::ajax(array(
//                                            'type' => 'GET',
//                                            'url' => CController::createUrl('ajaxHtmlUpdateVehicleStatusDataTable'),
//                                            'update' => '#vehicle_status_data_container',
//                                        )),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Plat #</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('PlateNumber', $plateNumber, array(
                                        'class' => 'form-select',
//                                        'onchange' => CHtml::ajax(array(
//                                            'type' => 'GET',
//                                            'url' => CController::createUrl('ajaxHtmlUpdateVehicleEntryDataTable'),
//                                            'update' => '#vehicle_entry_status_data_container',
//                                        )) . 
//                                        CHtml::ajax(array(
//                                            'type' => 'GET',
//                                            'url' => CController::createUrl('ajaxHtmlUpdateVehicleStatusDataTable'),
//                                            'update' => '#vehicle_status_data_container',
//                                        )),
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
                                    <span class="prefix">Tanggal Masuk</span>
                                </div>
                                <div class="small-4 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name'=>'StartDateIn',
                                        'value' => $startDateIn,
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                            'changeMonth'=>true,
                                            'changeYear'=>true,
                                        ),
                                        'htmlOptions'=>array(
                                            'class' => 'form-select',
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Date From',
//                                            'onchange' => CHtml::ajax(array(
//                                                'type' => 'GET',
//                                                'url' => CController::createUrl('ajaxHtmlUpdateVehicleEntryDataTable'),
//                                                'update' => '#vehicle_entry_status_data_container',
//                                            )),
                                        ),
                                    )); ?>
                                </div>

                                <div class="small-4 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name'=>'EndDateIn',
                                        'value' => $endDateIn,
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                            'changeMonth'=>true,
                                            'changeYear'=>true,
                                        ),
                                        'htmlOptions'=>array(
                                            'class' => 'form-select',
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Date To',
//                                            'onchange' => CHtml::ajax(array(
//                                                'type' => 'GET',
//                                                'url' => CController::createUrl('ajaxHtmlUpdateVehicleEntryDataTable'),
//                                                'update' => '#vehicle_entry_status_data_container',
//                                            )),
                                        ),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Tanggal Proses</span>
                                </div>
                                <div class="small-4 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name'=>'StartDateProcess',
                                        'value' => $startDateProcess,
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                            'changeMonth'=>true,
                                            'changeYear'=>true,
                                        ),
                                        'htmlOptions'=>array(
                                            'class' => 'form-select',
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Date From',
//                                            'onchange' => CHtml::ajax(array(
//                                                'type' => 'GET',
//                                                'url' => CController::createUrl('ajaxHtmlUpdateVehicleStatusDataTable'),
//                                                'update' => '#vehicle_status_data_container',
//                                            )),
                                        ),
                                    )); ?>
                                </div>

                                <div class="small-4 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name'=>'EndDateProcess',
                                        'value' => $endDateProcess,
                                        'options'=>array(
                                            'dateFormat'=>'yy-mm-dd',
                                            'changeMonth'=>true,
                                            'changeYear'=>true,
                                        ),
                                        'htmlOptions'=>array(
                                            'class' => 'form-select',
                                            'style'=>'margin-bottom:0px;',
                                            'placeholder'=>'Date To',
//                                            'onchange' => CHtml::ajax(array(
//                                                'type' => 'GET',
//                                                'url' => CController::createUrl('ajaxHtmlUpdateVehicleStatusDataTable'),
//                                                'update' => '#vehicle_status_data_container',
//                                            )),
                                        ),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit'));  ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <div id="vehicle_entry_status_data_container">
                    <?php $this->renderPartial('_vehicleEntry', array(
                        'startDateIn' => $startDateIn,
                        'endDateIn' => $endDateIn,
                        'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
                    )); ?>
                </div>

                <hr />

                <div id="vehicle_status_data_container">
                    <?php $this->renderPartial('_vehicleProcess', array(
                        'startDateProcess' => $startDateProcess,
                        'endDateProcess' => $endDateProcess,
                        'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
                    )); ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>