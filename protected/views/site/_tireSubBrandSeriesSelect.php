<?php echo CHtml::activeDropDownList($tire, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $tire->sub_brand_id)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand Series --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
        'update' => '#tire_stock_table',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>