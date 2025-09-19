<?php echo CHtml::activeDropDownList(Product::model(), 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $productSubMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Category --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
        'update' => '#product_stock_table',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>