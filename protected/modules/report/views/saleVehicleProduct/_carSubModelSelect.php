<?php echo CHtml::dropDownList('CarSubModelId', $carSubModelId, CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_model_id' => $carModelId), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- Pilih Car Sub Model --',
)); ?>