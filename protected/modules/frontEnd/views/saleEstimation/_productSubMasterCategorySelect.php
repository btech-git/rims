<?php echo CHtml::activeDropDownList(Product::model(), 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $product->product_master_category_id), array('order' => 'name ASC')), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Master Category --',
    'class' => 'form-select',
    'onchange' => CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
        'update' => '#product_sub_category',
    )) . 
    CHtml::ajax(array(
        'type' => 'GET',
        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
        'update' => '#product_data_container',
    )),
)); ?>