<?php echo CHtml::dropDownList('CarModel', $carModel, CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carMake), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- All --',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
        'update' => '#car_sub_model',
    )),
)); ?>