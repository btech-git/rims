<?php echo CHtml::dropDownList('SubCategoryId', '', CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $subMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Category --',
    'order' => 'name',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>