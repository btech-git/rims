<?php echo CHtml::dropDownList('CarSubModel', $carSubModel, CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_model_id' => $carModel), array('order' => 'name')), 'id', 'name'), array(
    'empty' => '-- All --',
)); ?>