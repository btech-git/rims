<?php
/* @var $this ForecastingBalanceController */
/* @var $model ForecastingBalance */

$this->breadcrumbs=array(
	'Forecasting Balances'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ForecastingBalance', 'url'=>array('index')),
	array('label'=>'Create ForecastingBalance', 'url'=>array('create')),
	array('label'=>'View ForecastingBalance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ForecastingBalance', 'url'=>array('admin')),
);
?>

<h1>Update ForecastingBalance <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>