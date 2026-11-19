<?php echo CHtml::dropDownList('CarModel', $carModel, CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carMake), array('order' => 't.name ASC')), 'id', 'name'), array(
    'empty' => '-- All --',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateCarSubModelSelect'),
        'update' => '#car_sub_model',
    )),
)); ?>