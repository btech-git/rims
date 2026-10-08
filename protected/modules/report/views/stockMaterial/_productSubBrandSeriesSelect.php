<?php echo CHtml::dropDownList('SubBrandSeriesId', $subBrandSeriesId, CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $subBrandId)), 'id', 'name'), array(
    'empty' => '-- All --',
    'order' => 'name',
)); ?>
<?php echo CHtml::hiddenField('SubCategory', ''); ?>