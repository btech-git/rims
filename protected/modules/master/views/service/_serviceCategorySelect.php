<?php echo CHtml::activeDropDownList(Service::model(), 'service_category_id', CHtml::listData(ServiceCategory::model()->findAllByAttributes(array('service_type_id' => $serviceTypeId)), 'id', 'name'), array(
    'empty' => '-- Pilih Category --',
    'order' => 'name',
    'onchange' => '$.fn.yiiGridView.update("service-grid", {data: {Service: {
        service_type_id: $("#Service_service_type_id").val(),
        service_category_id: $(this).val(),
    } } });',
)); ?>