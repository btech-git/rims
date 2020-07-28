<?php
/* @var $this EmployeeAbsenceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Absences',
);

$this->menu=array(
	array('label'=>'Create EmployeeAbsence', 'url'=>array('create')),
	array('label'=>'Manage EmployeeAbsence', 'url'=>array('admin')),
);
?>

<h1>Employee Absences</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
