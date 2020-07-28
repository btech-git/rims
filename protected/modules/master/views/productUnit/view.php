<?php
/* @var $this ProductUnitController */
/* @var $model ProductUnit */

$this->breadcrumbs=array(
	'Product Units'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProductUnit', 'url'=>array('index')),
	array('label'=>'Create ProductUnit', 'url'=>array('create')),
	array('label'=>'Update ProductUnit', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductUnit', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductUnit', 'url'=>array('admin')),
);
?>

<h1>View ProductUnit #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'unit_id',
	),
)); ?>
