<?php
/* @var $this UnitConversionController */
/* @var $model UnitConversion */

$this->breadcrumbs=array(
	'Company',
	'Unit Conversions'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Unit Conversion',
);

$this->menu=array(
	array('label'=>'List Unit Conversion', 'url'=>array('index')),
	array('label'=>'Create Unit Conversion', 'url'=>array('create')),
	array('label'=>'View Unit Conversion', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Unit Conversion', 'url'=>array('admin')),
);
?>
	<div id="maincontent">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
