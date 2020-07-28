<?php
/* @var $this ForecastingBalanceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Forecasting Balances',
);

$this->menu=array(
	array('label'=>'Create ForecastingBalance', 'url'=>array('create')),
	array('label'=>'Manage ForecastingBalance', 'url'=>array('admin')),
);
?>

<h1>Forecasting Balances</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
