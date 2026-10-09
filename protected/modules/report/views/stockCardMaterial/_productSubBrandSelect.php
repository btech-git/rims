<?php echo CHtml::activeDropDownList(Product::model(), 'sub_brand_id', CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $productBrandId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
        'update' => '#product_sub_brand_series',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>