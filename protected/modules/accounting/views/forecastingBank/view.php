<?php
/* @var $this ForecastingBankController */
/* @var $model ForecastingBank */

$this->breadcrumbs=array(
	'Forecasting Banks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ForecastingBank', 'url'=>array('index')),
	array('label'=>'Create ForecastingBank', 'url'=>array('create')),
	array('label'=>'Update ForecastingBank', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ForecastingBank', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ForecastingBank', 'url'=>array('admin')),
);
?>

<h1>View ForecastingBank #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'bank_name',
		'account_no',
		'status',
	),
)); ?>
