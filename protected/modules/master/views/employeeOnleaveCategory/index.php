<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Onleave Categories',
);

$this->menu=array(
	array('label'=>'Create EmployeeOnleaveCategory', 'url'=>array('create')),
	array('label'=>'Manage EmployeeOnleaveCategory', 'url'=>array('admin')),
);
?>

<h1>Employee Onleave Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
