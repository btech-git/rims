<?php
/* @var $this ForecastingBankController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Forecasting Banks',
);

$this->menu=array(
	array('label'=>'Create ForecastingBank', 'url'=>array('create')),
	array('label'=>'Manage ForecastingBank', 'url'=>array('admin')),
);
?>

<h1>Forecasting Banks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
