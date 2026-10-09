<?php echo CHtml::activeDropDownList(Product::model(), 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $productSubBrandId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand Series --',
    'order' => 'name',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>