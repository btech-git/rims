<?php
/* @var $this EmployeeWeekendController */
/* @var $model EmployeeWeekend */

$this->breadcrumbs=array(
	'Employee Weekends'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeWeekend', 'url'=>array('index')),
	array('label'=>'Manage EmployeeWeekend', 'url'=>array('admin')),
);
?>

<h1>Create EmployeeWeekend</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>