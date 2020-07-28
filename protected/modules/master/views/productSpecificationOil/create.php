<?php
/* @var $this ProductSpecificationOilController */
/* @var $model ProductSpecificationOil */

$this->breadcrumbs=array(
	'Product Specification Oils'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationOil', 'url'=>array('index')),
	array('label'=>'Manage ProductSpecificationOil', 'url'=>array('admin')),
);
?>

<h1>Create ProductSpecificationOil</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>