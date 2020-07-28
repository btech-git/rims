<?php
/* @var $this EmployeeIncentivesController */
/* @var $model EmployeeIncentives */

$this->breadcrumbs=array(
	'Employee Incentives'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EmployeeIncentives', 'url'=>array('index')),
	array('label'=>'Create EmployeeIncentives', 'url'=>array('create')),
	array('label'=>'Update EmployeeIncentives', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EmployeeIncentives', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EmployeeIncentives', 'url'=>array('admin')),
);
?>

<h1>View EmployeeIncentives #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'employee_id',
		'incentive_id',
		'amount',
	),
)); ?>
