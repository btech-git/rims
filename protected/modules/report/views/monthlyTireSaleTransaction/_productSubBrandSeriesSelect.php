<?php echo CHtml::activeDropDownList(Product::model(), 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $productSubBrandId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand Series --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
        'update' => '#product_stock_table',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>