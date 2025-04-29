<?php echo CHtml::dropDownList('SubBrandSeriesId', '', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $subBrandId)), 'id', 'name'), array(
    'empty' => '-- Pilih Sub Brand Series --',
    'order' => 'name',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>