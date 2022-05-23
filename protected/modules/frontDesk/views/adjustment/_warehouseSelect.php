<?php echo CHtml::activeDropDownList($adjustment->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAllByAttributes(array('branch_id' => $branchId)), 'id', 'name'), array(
    'empty' => '-- Pilih Warehouse --',
    'onchange' => CHtml::ajax(array(
        'type' => 'POST',
        'url' => CController::createUrl('ajaxHtmlUpdateAllProduct', array('id' => $adjustment->header->id)),
        'update' => '#detail_div',
    )),
)); ?>