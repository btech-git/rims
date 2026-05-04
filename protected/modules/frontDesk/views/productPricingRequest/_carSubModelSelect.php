<?php echo CHtml::activeDropDownList($model, 'vehicle_car_sub_model_id', CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_model_id' => $carModelId), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- Pilih Car Sub Model --',
)); ?>