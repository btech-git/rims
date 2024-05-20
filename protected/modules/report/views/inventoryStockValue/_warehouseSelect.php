<?php echo CHtml::activeDropDownList($inventory, 'warehouse_id', CHtml::listData(Warehouse::model()->findAllByAttributes(array('branch_id' => $branchId)), 'id', 'name'), array('empty' => '-- Pilih Warehouse --',
    'onchange' => CHtml::ajax(array(
        'dataType' => 'JSON',
        'type' => 'GET',
        'url' => CController::createUrl('ajaxJsonSpecificationCategory'),
        'success' => 'function(data) {
            $("#SpecificationCategory").val(data.specificationCategory);
        }',
    )),
)); ?>
<?php echo CHtml::hiddenField('SpecificationCategory', ''); ?>