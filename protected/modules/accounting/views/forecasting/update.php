<?php
/* @var $this ForecastingController */
/* @var $model Forecasting */

$this->breadcrumbs=array(
	'Forecastings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Forecasting', 'url'=>array('index')),
	array('label'=>'Create Forecasting', 'url'=>array('create')),
	array('label'=>'View Forecasting', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Forecasting', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>