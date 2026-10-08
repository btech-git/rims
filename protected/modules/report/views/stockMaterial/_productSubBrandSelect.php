<?php echo CHtml::dropDownList('SubBrandId', $subBrandId, CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $brandId)), 'id', 'name'), array(
    'empty' => '-- All --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
        'update' => '#product_sub_brand_series',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>