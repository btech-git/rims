<?php echo CHtml::activeDropDownList($tire, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $productBrandId), array('order' => 't.name ASC')), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand --',
    'order' => 'name',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateTireSubBrandSeriesSelect'),
        'update' => '#tire_sub_brand_series',
    )) . 
    CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateTireStockTable'),
        'update' => '#tire_stock_table',
    )),
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>