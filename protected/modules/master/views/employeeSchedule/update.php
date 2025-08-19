<?php
/* @var $this EmployeeScheduleController */
/* @var $model EmployeeSchedule */

$this->breadcrumbs=array(
	'Employee Schedules'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeSchedule', 'url'=>array('index')),
	array('label'=>'Create EmployeeSchedule', 'url'=>array('create')),
	array('label'=>'View EmployeeSchedule', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeSchedule', 'url'=>array('admin')),
);
?>

<h1>Update EmployeeSchedule <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>