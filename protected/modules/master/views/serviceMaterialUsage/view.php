<?php
/* @var $this ServiceMaterialUsageController */
/* @var $model ServiceMaterialUsage */

$this->breadcrumbs=array(
	'Service Material Usages'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServiceMaterialUsage', 'url'=>array('index')),
	array('label'=>'Create ServiceMaterialUsage', 'url'=>array('create')),
	array('label'=>'Update ServiceMaterialUsage', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServiceMaterialUsage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServiceMaterialUsage', 'url'=>array('admin')),
);
?>

<h1>View ServiceMaterialUsage #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'service_id',
		'product_id',
		'amount',
		'price',
		'brand',
	),
)); ?>
