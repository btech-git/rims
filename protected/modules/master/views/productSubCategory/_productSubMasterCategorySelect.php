<?php echo CHtml::activeDropDownList(Product::model(), 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $productMasterCategoryId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Master Category --',
    'order' => 'name',
)); ?>