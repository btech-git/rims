<div class="<?php echo $isSubmitted ? '' : 'd-none'; ?>" id="transaction-form">
    <?php echo CHtml::beginForm(array(), 'POST'); ?>
    
    <div class="form">
        <?php echo CHtml::errorSummary($saleEstimation->header); ?>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">FORM ESTIMASI</legend>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($saleEstimation->header, 'transaction_date', array('class' => 'form-label', 'label' => 'Tanggal')); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $saleEstimation->header,
                        'attribute' => "transaction_date",
                        'options' => array(
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
                <div class="col">
                    <?php echo CHtml::activeLabelEx($saleEstimation->header, 'vehicle_mileage', array('class' => 'form-label', 'label' => 'KM')); ?>
                    <?php echo CHtml::activeTextField($saleEstimation->header, 'vehicle_mileage', array('class' => 'form-control')); ?>
                    <?php echo CHtml::error($saleEstimation->header,'vehicle_mileage'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Kendaraan', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($saleEstimation->header, 'vehicle_id', array('value' => $saleEstimation->header->vehicle_id)); ?>
                    <?php echo CHtml::textField('VehicleName', '', array(
                        'class' => 'form-control readonly-form-input', 
                        'readonly' => true,
                        'onclick' => '$("#vehicle-dialog").dialog("open"); return false;',
                        'onkeypress' => 'if (event.keyCode == 13) { $("#vehicle-dialog").dialog("open"); return false; }',
                    )); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Customer', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeHiddenField($saleEstimation->header, 'customer_id', array('value' => $saleEstimation->header->customer_id)); ?>
                    <?php echo CHtml::textField('CustomerName', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Nomor Polisi', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::textField('PlateNumber', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Phone', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::textField('Phone', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Nomor Rangka', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::textField('FrameNumber', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Alamat', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::textField('Address', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($saleEstimation->header, 'employee_id_sale_person', array('class' => 'form-label', 'label' => 'Salesman')); ?>
                    <?php echo CHtml::activeDropDownlist($saleEstimation->header, 'employee_id_sale_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
                        "position_id" => 2,
                    )), "id", "name"), array("empty" => "--Assign Sales--", 'class' => 'form-select' . ($saleEstimation->header->hasErrors('employee_id_sale_person') ? ' is-invalid' : ''))); ?>
                    <?php echo CHtml::error($saleEstimation->header, 'employee_id_sale_person', array('class' => 'invalid-feedback d-block')); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Branch', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::textField('Branch', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($saleEstimation->header, 'problem', array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeTextArea($saleEstimation->header,'problem',array('rows'=>3, 'cols'=>30, 'class' => 'form-control')); ?>
                    <?php echo CHtml::error($saleEstimation->header,'problem'); ?>
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

        <div class="d-grid">
            <div class="row">
                <div class="col text-center">
                    <?php echo CHtml::htmlButton('Back', array('id' => 'back-button', 'class'=>'btn btn-success')); ?>
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?', 'class'=>'btn btn-danger')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'btn btn-success')); ?>
                </div>
            </div>
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>
    
    <?php echo CHtml::endForm(); ?>
</div>

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
//    'ajaxUpdate' => 'vehicle-grid',
//    'ajaxVar' => 'vehicle_ajax',
    'filter' => $vehicle,
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
            'header' => 'Kendaraan',
            'value' => '$data->carMakeModelSubCombination',
        ),
        array(
            'header' => 'Nomor Polisi',
            'value' => '$data->plate_number',
        ),
        array(
            'header' => 'Nomor Rangka',
            'value' => '$data->frame_number',
        ),
        array(
            'header' => 'Customer',
            'value' => 'empty($data->customer_id) ? "" : $data->customer->name',
        ),
    )
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        $('#back-button').on('click', function() {
            $('#transaction-form').addClass('d-none');
            $('#master-list').removeClass('d-none');
        });
    });
</script>
