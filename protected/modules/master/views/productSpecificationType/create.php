<?php
/* @var $this ProductSpecificationTypeController */
/* @var $model ProductSpecificationType */

$this->breadcrumbs=array(
	'Product'=>Yii::app()->baseUrl.'/master/product/admin',
	'Product Specification Types'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationType', 'url'=>array('index')),
	array('label'=>'Manage ProductSpecificationType', 'url'=>array('admin')),
);
?>

<h1>Create ProductSpecificationType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>