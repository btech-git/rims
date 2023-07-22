<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $model EmployeeOnleaveCategory */

$this->breadcrumbs=array(
	'Employee Onleave Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeOnleaveCategory', 'url'=>array('index')),
	array('label'=>'Manage EmployeeOnleaveCategory', 'url'=>array('admin')),
);
?>

<h1>Create Kategori Cuti Karyawan</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>