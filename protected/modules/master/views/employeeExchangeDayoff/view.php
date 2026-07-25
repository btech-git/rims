<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $model EmployeeExchangeDayoff */

$this->breadcrumbs=array(
	'Employee Exchange Dayoffs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeExchangeDayoff', 'url'=>array('index')),
	array('label'=>'Create EmployeeExchangeDayoff', 'url'=>array('create')),
	array('label'=>'Update EmployeeExchangeDayoff', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeExchangeDayoff', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeExchangeDayoff', 'url'=>array('admin')),
);
?>

<h1>View EmployeeExchangeDayoff #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date_dayoff_old',
		'date_dayoff_new',
		'employee_id',
	),
)); ?>
