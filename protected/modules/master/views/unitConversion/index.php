<?php
/* @var $this UnitConversionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Unit Conversions',
);

$this->menu=array(
	array('label'=>'Create UnitConversion', 'url'=>array('create')),
	array('label'=>'Manage UnitConversion', 'url'=>array('admin')),
);
?>

<h1>Unit Conversions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
