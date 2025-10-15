<div <?php if (!$isSubmitted): ?>style="display: none"<?php endif; ?> id="transaction-form">
    <?php echo CHtml::beginForm(array(), 'POST'); ?>
    
    <div class="form">
        <?php echo CHtml::errorSummary($saleEstimation->header); ?>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">FORM ESTIMASI</legend>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'transaction_date', array('class' => 'form-label', 'label' => 'Tanggal')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $saleEstimation->header,
                                            'attribute' => "transaction_date",
                                            'options' => array(
                                                'minDate' => '-1W',
                                                'maxDate' => '+6M',
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'class' => 'form-control readonly-form-input',
                                            ),
                                        )); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'transaction_date'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Customer', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeHiddenField($saleEstimation->header, 'customer_id', array('value' => $saleEstimation->header->customer_id)); ?>
                                        <?php echo CHtml::textField('CustomerName', empty($customer) ? '' : $customer->name, array(
                                            'class' => 'form-control', 
                                            'readonly' => true,
                                        )); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Kendaraan', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeHiddenField($saleEstimation->header, 'vehicle_id', array('value' => $saleEstimation->header->vehicle_id)); ?>
                                        <?php if (empty($vehicle)): ?>
                                            <?php echo CHtml::textField('VehicleName', '', array(
                                                'class' => 'form-control readonly-form-input', 
                                                'readonly' => true,
                                                'onclick' => '$("#vehicle-dialog").dialog("open"); return false;',
                                                'onkeypress' => 'if (event.keyCode == 13) { $("#vehicle-dialog").dialog("open"); return false; }',
                                            )); ?>
                                        <?php else: ?>
                                            <?php echo CHtml::textField('VehicleName', $vehicle->carMakeModelSubCombination, array(
                                                'class' => 'form-control', 
                                                'readonly' => true,
                                            )); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Nomor Polisi', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('PlateNumber', empty($vehicle) ? '' : $vehicle->plate_number, array('class' => 'form-control', 'readonly' => true)); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Alamat', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('Address', empty($customer) ? '' : $customer->address, array('class' => 'form-control', 'readonly' => true)); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Phone', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('Phone', empty($customer) ? '' : $customer->phone, array(
                                            'class' => 'form-control', 
                                            'readonly' => true,
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'employee_id_sale_person', array('class' => 'form-label', 'label' => 'Salesman')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownlist($saleEstimation->header, 'employee_id_sale_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
                                            "position_id" => 2,
                                        )), "id", "name"), array("empty" => "--Assign Sales--", 'class' => 'form-select' . ($saleEstimation->header->hasErrors('employee_id_sale_person') ? ' is-invalid' : ''))); ?>
                                        <?php echo CHtml::error($saleEstimation->header, 'employee_id_sale_person', array('class' => 'invalid-feedback d-block')); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'vehicle_mileage', array('class' => 'form-label', 'label' => 'KM')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($saleEstimation->header, 'vehicle_mileage', array('class' => 'form-control')); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'vehicle_mileage'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'problem', array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($saleEstimation->header,'problem',array('rows'=>3, 'cols'=>30, 'class' => 'form-control')); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'problem'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'note', array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($saleEstimation->header,'note',array('rows'=>3, 'cols'=>30, 'class' => 'form-control')); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'note'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">SUKU CADANG - SPAREPARTS</legend>
            <div class="detail" id="detail-product">
                <?php $this->renderPartial('_detailProduct', array(
                    'saleEstimation' => $saleEstimation,
                    'branches' => $branches,
                )); ?>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">JASA PERBAIKAN - SERVICE</legend>
            <div class="detail" id="detail-service">
                <?php $this->renderPartial('_detailService', array('saleEstimation' => $saleEstimation)); ?>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">TOTAL TRANSAKSI</legend>
            <div class="detail" id="detail-total">
                <?php $this->renderPartial('_detailTotal', array('saleEstimation' => $saleEstimation)); ?>
            </div>
        </fieldset>

        <div class="d-grid">
            <div class="row">
                <div class="col text-center">
                    <?php echo CHtml::htmlButton('Back', array('id' => 'back-button', 'class'=>'btn btn-warning btn-sm')); ?>
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?', 'class'=>'btn btn-danger btn-sm')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'btn btn-success btn-sm')); ?>
                </div>
            </div>
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>
    
    <?php echo CHtml::endForm(); ?>
</div>

<?php if ($saleEstimation->header->vehicle_id === null): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'vehicle-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Vehicle',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'vehicle-grid',
        'dataProvider' => $vehicleDataProvider,
        'filter' => $vehicleData,
        'selectionChanged' => 'js:function(id){
            $("#' . CHtml::activeId($saleEstimation->header, 'vehicle_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#vehicle-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#VehicleName").val("");
                $("#CustomerName").val("");
                $("#' . CHtml::activeId($saleEstimation->header, 'customer_id') . '").val("");
                $("#PlateNumber").val("");
                $("#FrameNumber").val("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonVehicle', array('id' => $saleEstimation->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#VehicleName").val(data.vehicle_name);
                        $("#CustomerName").val(data.customer_name);
                        $("#' . CHtml::activeId($saleEstimation->header, 'customer_id') . '").val(data.customer_id);
                        $("#PlateNumber").val(data.vehicle_plate_number);
                        $("#FrameNumber").val(data.vehicle_frame_number);
                    },
                });
            }
        }',
        'columns' => array(
            array(
                'header' => 'Nomor Polisi',
                'filter' => CHtml::activeTextField($vehicleData, 'plate_number'),
                'value' => 'CHtml::encode(CHtml::value($data, "plate_number"))',
            ),
            array(
                'header' => 'Kendaraan',
                'value' => 'CHtml::encode(CHtml::value($data, "carMakeModelSubCombination"))',
            ),
            array(
                'header' => 'Nomor Rangka',
                'value' => 'CHtml::encode(CHtml::value($data, "frame_number"))',
            ),
            array(
                'header' => 'Customer',
                'filter' => CHtml::textField('CustomerName', $customerName),
                'value' => 'empty($data->customer_id) ? "" : $data->customer->name',
            ),
        )
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php endif; ?>

<script>
    $(document).ready(function() {
        $('#back-button').on('click', function() {
            $('#transaction-form').hide();
            $('#master-list').show();
        });
    });
</script>
