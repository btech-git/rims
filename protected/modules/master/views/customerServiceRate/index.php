<?php
/* @var $this CustomerServiceRateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Customer Service Rates',
);

$this->menu=array(
	array('label'=>'Create CustomerServiceRate', 'url'=>array('create')),
	array('label'=>'Manage CustomerServiceRate', 'url'=>array('admin')),
);
?>

<h1>Customer Service Rates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
