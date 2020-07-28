<?php echo CHtml::activeDropDownList(Vehicle::model(), 'car_model_id', CHtml::listData(CarModel::model()->findAllByAttributes(array('car_make_id' => $carMakeId, 'order' => 'name')), 'id', 'name'), array(
    'empty' => '-- Pilih Car Model --',
    'onchange' => '
        $.fn.yiiGridView.update("vehicle-grid", {data: {Vehicle: {
            customer_name: $("#' . CHtml::activeId($vehicle, 'customer_name') . '").val(),
            customer_type: $("#' . CHtml::activeId($vehicle, 'customer_type') . '").val(),
            plate_number: $("#' . CHtml::activeId($vehicle, 'plate_number') . '").val(),
            car_make_id: $("#' . CHtml::activeId($vehicle, 'car_make_id') . '").val(),
            car_model_id: $(this).val(),
            car_sub_model_id: $("#' . CHtml::activeId($vehicle, 'car_sub_model_id') . '").val(),
            customer_name_checked: $("#' . CHtml::activeId($vehicle, 'customer_name_checked') . '").is(":checked") ? 1 : 0,
            plate_number_checked: $("#' . CHtml::activeId($vehicle, 'plate_number_checked') . '").is(":checked") ? 1 : 0,
        } } });
    ',
)); ?>