<?php
/* @var $this EmployeeTimesheetController */
/* @var $model EmployeeTimesheet */

$this->breadcrumbs=array(
	'Employee Timesheets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeTimesheet', 'url'=>array('index')),
	array('label'=>'Create EmployeeTimesheet', 'url'=>array('create')),
	array('label'=>'Update EmployeeTimesheet', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeTimesheet', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeTimesheet', 'url'=>array('admin')),
);
?>

<h1>View Employee Timesheet #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'employee.name',
        'date',
        'clock_in',
        'clock_out',
        array(
            'header' => 'duration_late',
            'value' => CHtml::encode(CHtml::value($model, 'lateTimeDiff')),
        ),
        array(
            'header' => 'duration_work',
            'value' => CHtml::encode(CHtml::value($model, 'workTimeDiff')),
        ),
        array(
            'label' => 'Status',
            'value' => CHtml::encode(CHtml::value($model, 'employeeOnleaveCategory.name')),
        ),
    ),
)); ?>
