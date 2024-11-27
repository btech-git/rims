<?php echo CHtml::activeDropDownList(Coa::model(), 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $categoryId)), 'id', 'name'), array(
    'empty' => '-- All --',
    'order' => 'name',
    'onchange' => '
    $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
        coa_sub_category_id: $(this).val(),
        id: $("#coa_id").val(),
        code: $("#coa_code").val(),
        name: $("#coa_name").val(),
        coa_category_id: $("#coa_category_id").val(),
    } } });',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>