<?php echo CHtml::activeDropDownList(Vehicle::model(), 'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_model_id' => $carModelId), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- Pilih Car Sub Model --',
    'onchange' => '
        $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
            customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
            customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
            plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
            car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
            car_model_id: $("#' . CHtml::activeId($vehicle, 'car_model_id') . '").val(),
            car_sub_model_id: $(this).val(),
        } } });
    ',
)); ?>