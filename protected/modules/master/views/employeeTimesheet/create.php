<?php
/* @var $this EmployeeTimesheetController */
/* @var $model EmployeeTimesheet */

$this->breadcrumbs=array(
	'Employee Timesheets'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeTimesheet', 'url'=>array('index')),
	array('label'=>'Manage EmployeeTimesheet', 'url'=>array('admin')),
);
?>

<h1>Create EmployeeTimesheet</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>