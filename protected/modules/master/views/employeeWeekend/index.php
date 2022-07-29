<?php
/* @var $this EmployeeWeekendController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Weekends',
);

$this->menu=array(
	array('label'=>'Create EmployeeWeekend', 'url'=>array('create')),
	array('label'=>'Manage EmployeeWeekend', 'url'=>array('admin')),
);
?>

<h1>Employee Weekends</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
