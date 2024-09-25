<?php echo CHtml::activeDropDownList(Product::model(), 'sub_brand_id', CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $productBrandId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
        'update' => '#product_sub_brand_series',
    )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
        brand_id: $("#Product_brand_id").val(),
        sub_brand_id: $(this).val(),
        sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
        product_master_category_id: $("#Product_product_master_category_id").val(),
        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
        product_sub_category_id: $("#Product_product_sub_category_id").val(),
        manufacturer_code: $("#Product_manufacturer_code").val(),
        name: $("#Product_name").val(),
        id: $("#Product_id").val(),
    } } });',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>