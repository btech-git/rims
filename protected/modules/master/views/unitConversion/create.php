<?php
/* @var $this UnitConversionController */
/* @var $model UnitConversion */

$this->breadcrumbs=array(
	'Company',
	'Unit Conversions'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UnitConversion', 'url'=>array('index')),
	array('label'=>'Manage UnitConversion', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>