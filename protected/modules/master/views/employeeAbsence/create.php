<?php
/* @var $this EmployeeAbsenceController */
/* @var $model EmployeeAbsence */

$this->breadcrumbs=array(
	'Employee Absences'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List EmployeeAbsence', 'url'=>array('index')),
	array('label'=>'Manage EmployeeAbsence', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create EmployeeAbsence</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>