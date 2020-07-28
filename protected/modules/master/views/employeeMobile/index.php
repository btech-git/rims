<?php
/* @var $this EmployeeMobileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Mobiles',
);

$this->menu=array(
	array('label'=>'Create EmployeeMobile', 'url'=>array('create')),
	array('label'=>'Manage EmployeeMobile', 'url'=>array('admin')),
);
?>

<h1>Employee Mobiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
