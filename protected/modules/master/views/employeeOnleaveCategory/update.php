<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $model EmployeeOnleaveCategory */

$this->breadcrumbs=array(
	'Employee Onleave Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeOnleaveCategory', 'url'=>array('index')),
	array('label'=>'Create EmployeeOnleaveCategory', 'url'=>array('create')),
	array('label'=>'View EmployeeOnleaveCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeOnleaveCategory', 'url'=>array('admin')),
);
?>

<h1>Update EmployeeOnleaveCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>