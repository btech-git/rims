<?php echo CHtml::dropDownList('CategoryId', $categoryId, CHtml::listData(ServiceCategory::model()->findAllByAttributes(array('service_type_id' => $typeId)), 'id', 'name'), array(
    'empty' => '-- Pilih Category --',
    'order' => 'name',
)); ?>