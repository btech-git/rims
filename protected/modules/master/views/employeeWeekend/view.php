<?php
/* @var $this EmployeeWeekendController */
/* @var $model EmployeeWeekend */

$this->breadcrumbs=array(
	'Employee Weekends'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeWeekend', 'url'=>array('index')),
	array('label'=>'Create EmployeeWeekend', 'url'=>array('create')),
	array('label'=>'Update EmployeeWeekend', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeWeekend', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeWeekend', 'url'=>array('admin')),
);
?>

<h1>View Employee Weekend #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'employee.name',
		'off_day',
	),
)); ?>
