<?php
/* @var $this EmployeeAbsenceController */
/* @var $model EmployeeAbsence */

$this->breadcrumbs=array(
	'Employee Absences'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List EmployeeAbsence', 'url'=>array('index')),
	array('label'=>'Create EmployeeAbsence', 'url'=>array('create')),
	array('label'=>'View EmployeeAbsence', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeAbsence', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update EmployeeAbsence <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>