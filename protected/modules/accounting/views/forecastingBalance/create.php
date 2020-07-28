<?php
/* @var $this ForecastingBalanceController */
/* @var $model ForecastingBalance */

$this->breadcrumbs=array(
	'Forecasting Balances'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ForecastingBalance', 'url'=>array('index')),
	array('label'=>'Manage ForecastingBalance', 'url'=>array('admin')),
);
?>

<h1>Create ForecastingBalance</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>