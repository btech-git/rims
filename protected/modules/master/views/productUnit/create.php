<?php
/* @var $this ProductUnitController */
/* @var $model ProductUnit */

$this->breadcrumbs=array(
	'Product Units'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductUnit', 'url'=>array('index')),
	array('label'=>'Manage ProductUnit', 'url'=>array('admin')),
);
?>

<h1>Create ProductUnit</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>