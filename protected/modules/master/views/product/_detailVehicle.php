<?php foreach ($product->vehicleDetails as $i => $vehicleDetail): ?>
    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <label class="prefix">Vehicle Car Make</label>
            </div>
            <div class="small-8 columns">
                <?php echo CHtml::activeDropDownList($vehicleDetail, "[$i]vehicle_car_make_id", CHtml::listData(VehicleCarMake::model()->findAll(), 'id', 'name'), array(
                    'prompt' => '[--Select Vehicle Car Make--]',
                    'onchange' => 'jQuery.ajax({
                        type: "POST",
                        //dataType: "JSON",
                        url: "' . CController::createUrl('ajaxGetVehicleCarModel') . '/index/' . $i . '",
                        data: jQuery("form").serialize(),
                        success: function(data){
                            console.log("#Product_' . $i . '_vehicle_car_model_id");
                            jQuery("#Product_vehicle_car_model_id").html(data);
                            jQuery("#ProductVehicle_' . $i . '_vehicle_car_model_id").html(data);
                        },
                    });'
                )); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <label class="prefix">Vehicle Car Model</label>
            </div>
            <div class="small-8 columns">
                <?php echo CHtml::activeDropDownList($vehicleDetail, "[$i]vehicle_car_model_id", CHtml::listData(VehicleCarModel::model()->findAll(), 'id', 'name'), array(
                    'prompt' => '[--Select Vehicle Car Model--]',
                )); ?>
            </div>
        </div>
    </div>

    <?php echo CHtml::button('X', array(
        'class' => 'button extra right',
        'onclick' => CHtml::ajax(array(
            'type' => 'POST',
            'url' => CController::createUrl('ajaxHtmlRemoveVehicleDetail', array('id' => $product->header->id, 'index' => $i)),
            'update' => '#vehicle',
        )),
    )); ?>			
<?php endforeach; ?>