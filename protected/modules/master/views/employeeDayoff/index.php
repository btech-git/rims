<?php
/* @var $this EmployeeDayoffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Dayoffs',
);

$this->menu=array(
	array('label'=>'Create EmployeeDayoff', 'url'=>array('create')),
	array('label'=>'Manage EmployeeDayoff', 'url'=>array('admin')),
);
?>

<h1>Employee Dayoffs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
