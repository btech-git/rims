<?php echo CHtml::activeDropDownList(Coa::model(), 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $coaCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Category --',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>