<?php echo CHtml::activeDropDownList(ProductSubCategory::model(), 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $productMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Master Category --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
        'update' => '#product_sub_category',
    )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
        product_master_category_id: $("#Product_product_master_category_id").val(),
        product_sub_master_category_id: $(this).val(),
        id: $("#Product_product_sub_category_id").val(),
    } } });',
)); ?>