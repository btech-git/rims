<?php
/* @var $this ForecastingBankController */
/* @var $model ForecastingBank */

$this->breadcrumbs=array(
	'Forecasting Banks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ForecastingBank', 'url'=>array('index')),
	array('label'=>'Manage ForecastingBank', 'url'=>array('admin')),
);
?>

<h1>Create ForecastingBank</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>