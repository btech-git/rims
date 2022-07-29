<?php
/* @var $this EmployeeWeekendController */
/* @var $model EmployeeWeekend */

$this->breadcrumbs=array(
	'Employee Weekends'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeWeekend', 'url'=>array('index')),
	array('label'=>'Create EmployeeWeekend', 'url'=>array('create')),
	array('label'=>'View EmployeeWeekend', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeWeekend', 'url'=>array('admin')),
);
?>

<h1>Update EmployeeWeekend <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>