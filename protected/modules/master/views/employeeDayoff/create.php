<?php
/* @var $this EmployeeDayoffController */
/* @var $model EmployeeDayoff */

$this->breadcrumbs=array(
	'Employee Dayoffs'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List EmployeeDayoff', 'url'=>array('index')),
	array('label'=>'Manage EmployeeDayoff', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create EmployeeDayoff</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array(
			'model'=>$model,
			'employee'=>$employee,
			'employeeDataProvider'=>$employeeDataProvider,
	)); ?></div>