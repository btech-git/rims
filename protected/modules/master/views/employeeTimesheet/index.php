<?php
/* @var $this EmployeeTimesheetController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Timesheets',
);

$this->menu=array(
	array('label'=>'Create EmployeeTimesheet', 'url'=>array('create')),
	array('label'=>'Manage EmployeeTimesheet', 'url'=>array('admin')),
);
?>

<h1>Employee Timesheets</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
