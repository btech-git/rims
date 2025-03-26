<?php echo CHtml::dropDownList('ServiceCategoryId', $serviceCategoryId, CHtml::listData(ServiceCategory::model()->findAllByAttributes(array('service_type_id' => $serviceTypeId)), 'id', 'name'), array(
    'empty' => '-- Pilih Category --',
    'order' => 'name',
)); ?>