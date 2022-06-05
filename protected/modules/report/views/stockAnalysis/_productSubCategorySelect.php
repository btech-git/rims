<?php echo CHtml::dropDownList('ProductSubCategoryId', $productSubCategoryId, CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $productSubMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Category --',
    'order' => 'name',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>