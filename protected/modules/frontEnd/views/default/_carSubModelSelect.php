<?php echo CHtml::activeDropDownList(Vehicle::model(), 'car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_model_id' => $carModelId), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- Pilih Car Sub Model --',
    'class' => 'form-select',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateVehicleDataTable'),
        'update' => '#vehicle_data_container',
    )),
)); ?>