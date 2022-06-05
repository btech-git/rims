<?php echo CHtml::dropDownList('ProductSubMasterCategoryId', $productSubMasterCategoryId, CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $productMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Master Category --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
        'update' => '#product_sub_category',
    )),
)); ?>