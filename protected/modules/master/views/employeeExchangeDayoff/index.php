<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Exchange Dayoffs',
);

$this->menu=array(
	array('label'=>'Create EmployeeExchangeDayoff', 'url'=>array('create')),
	array('label'=>'Manage EmployeeExchangeDayoff', 'url'=>array('admin')),
);
?>

<h1>Employee Exchange Dayoffs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
