<?php
/* @var $this ForecastingController */
/* @var $model Forecasting */

$this->breadcrumbs=array(
	'Forecastings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Forecasting', 'url'=>array('index')),
	array('label'=>'Manage Forecasting', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>