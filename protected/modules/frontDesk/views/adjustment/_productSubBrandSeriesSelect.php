<?php echo CHtml::activeDropDownList(Product::model(), 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $productSubBrandId)), 'id', 'name'), array('empty' => '-- Pilih Sub Brand Series --',
    'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
        product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
        brand_id: $("#Product_brand_id").val(),
        sub_brand_id: $("#Product_sub_brand_id").val(),
        sub_brand_series_id: $(this).val(),
        product_master_category_id: $("#Product_product_master_category_id").val(),
        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
        product_sub_category_id: $("#Product_product_sub_category_id").val(),
        manufacturer_code: $("#Product_manufacturer_code").val(),
        name: $("#Product_name").val(),
        id: $("#Product_id").val(),
    } } });',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>