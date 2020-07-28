<?php
/* @var $this EmployeeAttendanceController */
/* @var $model EmployeeAttendance */

$this->breadcrumbs=array(
	'Employee Attendances'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List EmployeeAttendance', 'url'=>array('index')),
	array('label'=>'Create EmployeeAttendance', 'url'=>array('create')),
	array('label'=>'View EmployeeAttendance', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeAttendance', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update EmployeeAttendance <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>