<?php
/* @var $this ProductSpecificationTireController */
/* @var $model ProductSpecificationTire */

$this->breadcrumbs=array(
	'Product Specification Tires'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationTire', 'url'=>array('index')),
	array('label'=>'Manage ProductSpecificationTire', 'url'=>array('admin')),
);
?>

<h1>Create ProductSpecificationTire</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>