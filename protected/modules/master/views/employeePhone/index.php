<?php
/* @var $this EmployeePhoneController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Phones',
);

$this->menu=array(
	array('label'=>'Create EmployeePhone', 'url'=>array('create')),
	array('label'=>'Manage EmployeePhone', 'url'=>array('admin')),
);
?>

<h1>Employee Phones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
