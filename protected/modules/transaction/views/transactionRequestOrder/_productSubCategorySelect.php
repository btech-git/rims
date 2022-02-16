<?php echo CHtml::activeDropDownList(Product::model(), 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $productSubMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Category --',
    'order' => 'name',
    'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
        product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
        brand_id: $("#Product_brand_id").val(),
        sub_brand_id: $("#Product_sub_brand_id").val(),
        sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
        product_master_category_id: $("#Product_product_master_category_id").val(),
        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
        product_sub_category_id: $(this).val(),
        manufacturer_code: $("#Product_manufacturer_code").val(),
        name: $("#Product_name").val(),
        id: $("#Product_id").val(),
    } } });',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>