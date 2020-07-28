<?php
/* @var $this CustomerServiceRateController */
/* @var $model CustomerServiceRate */

$this->breadcrumbs=array(
	'Customer Service Rates'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CustomerServiceRate', 'url'=>array('index')),
	array('label'=>'Create CustomerServiceRate', 'url'=>array('create')),
	array('label'=>'Update CustomerServiceRate', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CustomerServiceRate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CustomerServiceRate', 'url'=>array('admin')),
);
?>

<h1>View CustomerServiceRate #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'customer_id',
		'service_id',
		'rate',
	),
)); ?>
