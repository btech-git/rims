<?php echo CHtml::activeDropDownList(Vehicle::model(), 'car_model_id', CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carMakeId), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- Pilih Car Model --',
    'class' => 'form-select',
    'onchange' =>  CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
        'update' => '#car_sub_model',
    )) . 
    CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateVehicleDataTable'),
        'update' => '#vehicle_data_container',
    )),
)); ?>