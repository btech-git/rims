<?php echo CHtml::activeDropDownList(Product::model(), 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $productMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Master Category --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
        'update' => '#product_sub_category',
    )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
        product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
        brand_id: $("#Product_brand_id").val(),
        sub_brand_id: $("#Product_sub_brand_id").val(),
        sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
        product_master_category_id: $("#Product_product_master_category_id").val(),
        product_sub_master_category_id: $(this).val(),
        product_sub_category_id: $("#Product_product_sub_category_id").val(),
        manufacturer_code: $("#Product_manufacturer_code").val(),
        name: $("#Product_name").val(),
        id: $("#Product_id").val(),
    } } });',
)); ?>