<?php echo CHtml::dropDownList('CarModelId', $carModelId, CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carMakeId), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- Pilih Car Model --',
    'onchange' =>  CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
        'update' => '#car_sub_model',
    )),
)); ?>