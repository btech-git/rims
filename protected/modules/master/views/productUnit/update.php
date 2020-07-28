<?php
/* @var $this ProductUnitController */
/* @var $model ProductUnit */

$this->breadcrumbs=array(
	'Product Units'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductUnit', 'url'=>array('index')),
	array('label'=>'Create ProductUnit', 'url'=>array('create')),
	array('label'=>'View ProductUnit', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductUnit', 'url'=>array('admin')),
);
?>

<h1>Update ProductUnit <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>