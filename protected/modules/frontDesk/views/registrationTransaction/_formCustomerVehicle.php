<?php echo CHtml::beginForm(array(), 'POST'); ?>
<div class="row">
    <div class="medium-6 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Kendaraan', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::activeHiddenField($registrationTransaction->header, 'vehicle_id'); ?>
                    <?php echo CHtml::textField('VehicleName', '', array(
                        'class' => 'form-control readonly-form-input', 
                        'readonly' => true,
                        'onclick' => '$("#vehicle-dialog").dialog("open"); return false;',
                        'onkeypress' => 'if (event.keyCode == 13) { $("#vehicle-dialog").dialog("open"); return false; }',
                    )); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Nomor Polisi', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::textField('PlateNumber', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Warna', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::textField('Color', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Nomor Rangka', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::textField('FrameNumber', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div> 
    
    <div class="medium-6 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Customer', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::activeHiddenField($registrationTransaction->header, 'customer_id'); ?>
                    <?php echo CHtml::textField('CustomerName', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Alamat', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::textField('Address', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Phone', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::textField('Phone', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <label class="prefix"><?php echo CHtml::label('Email', false, array('class' => 'form-label')); ?></label>
                </div>
                <div class="small-8 columns">
                    <?php echo CHtml::textField('Email', '', array('class' => 'form-control', 'readonly' => true)); ?>
                </div>
            </div>
        </div>
    </div>
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
    'filter' => $vehicle,
    'selectionChanged' => 'js:function(id){
        $("#' . CHtml::activeId($registrationTransaction->header, 'vehicle_id') . '").val($.fn.yiiGridView.getSelection(id));
        $("#vehicle-dialog").dialog("close");
        if ($.fn.yiiGridView.getSelection(id) == "") {
            $("#' . CHtml::activeId($registrationTransaction->header, 'customer_id') . '").val("");
            $("#CustomerName").val("");
            $("#Address").val("");
            $("#Phone").val("");
            $("#Email").val("");
            $("#VehicleName").val("");
            $("#PlateNumber").val("");
            $("#FrameNumber").val("");
            $("#Color").val("");
        } else {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "' . CController::createUrl('ajaxJsonVehicle', array('id' => $registrationTransaction->header->id)) . '",
                data: $("form").serialize(),
                success: function(data) {
                    $("#' . CHtml::activeId($registrationTransaction->header, 'customer_id') . '").val(data.customer_id);
                    $("#CustomerName").val(data.customer_name);
                    $("#Address").val(data.customer_address);
                    $("#Phone").val(data.customer_phone);
                    $("#Email").val(data.customer_email);
                    $("#VehicleName").val(data.vehicle_name);
                    $("#PlateNumber").val(data.vehicle_plate_number);
                    $("#FrameNumber").val(data.vehicle_frame_number);
                    $("#Color").val(data.vehicle_color);
                },
            });
        }
    }',
    'columns' => array(
        array(
            'header' => 'Kendaraan',
            'value' => 'CHtml::encode(CHtml::value($data, "carMakeModelSubCombination"))',
        ),
        array(
            'header' => 'Nomor Polisi',
            'value' => 'CHtml::encode(CHtml::value($data, "plate_number"))',
        ),
        array(
            'header' => 'Warna',
            'value' => 'CHtml::encode(CHtml::value($data, "color.name"))',
        ),
        array(
            'header' => 'Nomor Rangka',
            'value' => 'CHtml::encode(CHtml::value($data, "frame_number"))',
        ),
        array(
            'header' => 'Customer',
            'value' => 'empty($data->customer_id) ? "" : $data->customer->name',
        ),
    )
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php echo CHtml::endForm(); ?>