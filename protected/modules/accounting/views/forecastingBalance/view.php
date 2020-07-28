<?php
/* @var $this ForecastingBalanceController */
/* @var $model ForecastingBalance */

$this->breadcrumbs=array(
	'Forecasting Balances'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ForecastingBalance', 'url'=>array('index')),
	array('label'=>'Create ForecastingBalance', 'url'=>array('create')),
	array('label'=>'Update ForecastingBalance', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ForecastingBalance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ForecastingBalance', 'url'=>array('admin')),
);
?>

<h1>View ForecastingBalance #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'years',
		'month',
		'amount',
		'bank_id',
	),
)); ?>
