<?php
/* @var $this EmployeeAbsenceController */
/* @var $model EmployeeAbsence */

$this->breadcrumbs=array(
	'Employee Absences'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeAbsence', 'url'=>array('index')),
	array('label'=>'Create EmployeeAbsence', 'url'=>array('create')),
	array('label'=>'Update EmployeeAbsence', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeAbsence', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeAbsence', 'url'=>array('admin')),
);
?>

<!--<h1>View EmployeeAbsence #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage EmployeeAbsence</a>
		<a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-edit"></span>Edit</a>
		<h1>View EmployeeAbsence #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
		'employee_id',
		'month',
		'total_attendance',
		'absent',
		'bonus',
		'overtime',
			),
		)); ?>
	</div>
</div>