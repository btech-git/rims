<?php echo CHtml::dropDownList('CarModelId', $carModelId, CHtml::listData(VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carMakeId)), 'id', 'name'), array(
    'empty' => '-- Pilih Car Model --',
)); ?>