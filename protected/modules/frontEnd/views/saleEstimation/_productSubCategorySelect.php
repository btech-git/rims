<?php echo CHtml::activeDropDownList(Product::model(), 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $product->product_sub_master_category_id), array('order' => 'name ASC')), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Category --',
    'class' => 'form-select',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
        'update' => '#product_data_container',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>