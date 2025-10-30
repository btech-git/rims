<?php echo CHtml::dropDownList('SubMasterCategoryId', $subMasterCategoryId, CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $masterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Master Category --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
        'update' => '#product_sub_category',
    )),
)); ?>