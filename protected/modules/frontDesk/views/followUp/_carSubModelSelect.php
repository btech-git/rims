<?php echo CHtml::dropDownList('CarSubModel', $carSubModel, CHtml::listData(VehicleCarSubModel::model()->findAllByAttributes(array('car_model_id' => $carModel), array('order' => 't.name ASC')), 'id', 'name'), array(
    'empty' => '-- All --',
)); ?>