<?php
/* @var $this ForecastingController */
/* @var $model Forecasting */

$this->breadcrumbs=array(
	'Forecastings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Forecasting', 'url'=>array('index')),
	array('label'=>'Create Forecasting', 'url'=>array('create')),
	array('label'=>'Update Forecasting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Forecasting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Forecasting', 'url'=>array('admin')),
);
?>

<h1>View Forecasting #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'transaction_id',
		'type_forecasting',
		'due_date',
		'payment_date',
		'realization_date',
		'bank_id',
		'coa_id',
		'amount',
		'balance',
		'realization_balance',
		'status',
		'notes',
	),
)); ?>

<div class="row">
	<div class="small-12 medium-6" style="padding: 10px;">
		<img src="<?= Yii::app()->baseUrl.'/uploads/forecasting/'.$model->image_attach?>" style="max-width:500px;">
	</div>
</div>