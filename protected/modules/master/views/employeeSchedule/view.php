<?php
/* @var $this EmployeeScheduleController */
/* @var $model EmployeeSchedule */

$this->breadcrumbs=array(
	'Employee Schedules'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeSchedule', 'url'=>array('index')),
	array('label'=>'Create EmployeeSchedule', 'url'=>array('create')),
	array('label'=>'Update EmployeeSchedule', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeSchedule', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeSchedule', 'url'=>array('admin')),
);
?>

<h1>View EmployeeSchedule #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'employee_id',
		'branch_id',
		'working_date',
	),
)); ?>
