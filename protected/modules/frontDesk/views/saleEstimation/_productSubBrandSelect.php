<?php echo CHtml::activeDropDownList(Product::model(), 'sub_brand_id', CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $product->brand_id), array('order' => 'name ASC')), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand --',
    'class' => 'form-select',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
        'update' => '#product_sub_brand_series',
    )) . 
    CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
        'update' => '#product_data_container',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>