<?php
/* @var $this QuickServiceDetailController */
/* @var $model QuickServiceDetail */

$this->breadcrumbs=array(
	'Quick Service Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List QuickServiceDetail', 'url'=>array('index')),
	array('label'=>'Create QuickServiceDetail', 'url'=>array('create')),
	array('label'=>'Update QuickServiceDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete QuickServiceDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage QuickServiceDetail', 'url'=>array('admin')),
);
?>

<h1>View QuickServiceDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'quick_service_id',
		'service_id',
		'price',
	),
)); ?>
