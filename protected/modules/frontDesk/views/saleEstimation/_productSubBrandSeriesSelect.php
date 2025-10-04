<?php echo CHtml::activeDropDownList(Product::model(), 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $product->sub_brand_id), array('order' => 'name ASC')), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand Series --',
    'class' => 'form-select',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
        'update' => '#product_data_container',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>