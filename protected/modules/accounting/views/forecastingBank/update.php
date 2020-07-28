<?php
/* @var $this ForecastingBankController */
/* @var $model ForecastingBank */

$this->breadcrumbs=array(
	'Forecasting Banks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ForecastingBank', 'url'=>array('index')),
	array('label'=>'Create ForecastingBank', 'url'=>array('create')),
	array('label'=>'View ForecastingBank', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ForecastingBank', 'url'=>array('admin')),
);
?>

<h1>Update ForecastingBank <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>