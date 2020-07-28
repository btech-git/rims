<?php
/* @var $this ForecastingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Forecastings',
);

$this->menu=array(
	array('label'=>'Create Forecasting', 'url'=>array('create')),
	array('label'=>'Manage Forecasting', 'url'=>array('admin')),
);
?>

<h1>Forecastings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
