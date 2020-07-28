<?php
/* @var $this EmployeeAttendanceController */
/* @var $model EmployeeAttendance */

$this->breadcrumbs=array(
	'Employee Attendances'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List EmployeeAttendance', 'url'=>array('index')),
	array('label'=>'Manage EmployeeAttendance', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create EmployeeAttendance</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>