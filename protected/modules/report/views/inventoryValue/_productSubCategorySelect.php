<?php echo CHtml::activeDropDownList(ProductSubCategory::model(), 'id', CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $productSubMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Category --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
        'update' => '#product_stock_table',
    )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
        product_master_category_id: $("#Product_product_master_category_id").val(),
        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
        id: $(this).val(),
    } } });',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>