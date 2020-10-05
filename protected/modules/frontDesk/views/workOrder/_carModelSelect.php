<?php echo CHtml::activeDropDownList($model, 'car_model_code', CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carMakeId)), 'id', 'name'), array(
    'empty' => '-- All --',
    'onchange' => '
        $.fn.yiiGridView.update("work-order-grid", {data: {RegistrationTransaction: {
            car_model_code: $(this).val(),
            transaction_date_from: $("#' . CHtml::activeId($model, 'transaction_date_from') . '").val(),
            transaction_date_to: $("#' . CHtml::activeId($model, 'transaction_date_to') . '").val(),
            car_make_code: $("#' . CHtml::activeId($model, 'car_make_code') . '").val(),
            plate_number: $("#' . CHtml::activeId($model, 'plate_number') . '").val(),
            work_order_number: $("#' . CHtml::activeId($model, 'work_order_number') . '").val(),
            status: $("#' . CHtml::activeId($model, 'status') . '").val(),
            repair_type: $("#' . CHtml::activeId($model, 'repair_type') . '").val(),
            branch_id: $("#' . CHtml::activeId($model, 'branch_id') . '").val(),
        } } });
    ',
)); ?>

<?php echo $model->vehicle->car_make_id . ' - 2'; ?>