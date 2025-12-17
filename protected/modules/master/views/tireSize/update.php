<?php
/* @var $this TireSizeController */
/* @var $model TireSize */

$this->breadcrumbs=array(
	'Tire Sizes'=>array('index'),
	$model->section_width=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TireSize', 'url'=>array('index')),
	array('label'=>'Create TireSize', 'url'=>array('create')),
	array('label'=>'View TireSize', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TireSize', 'url'=>array('admin')),
);
?>

<h1>Update Tire Specifications <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>