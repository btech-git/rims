<?php
/* @var $this EmployeeAttendanceController */
/* @var $model EmployeeAttendance */

$this->breadcrumbs=array(
	'Employee Attendances'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeAttendance', 'url'=>array('index')),
	array('label'=>'Create EmployeeAttendance', 'url'=>array('create')),
	array('label'=>'Update EmployeeAttendance', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeAttendance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeAttendance', 'url'=>array('admin')),
);
?>

<!--<h1>View EmployeeAttendance #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage EmployeeAttendance</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View EmployeeAttendance #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'employee_id',
		'user_id',
		'date',
		'login_time',
		'logout_time',
			),
		)); ?>
	</div>
</div>