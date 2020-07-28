<?php
/* @var $this EmployeeIncentivesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Incentives',
);

$this->menu=array(
	array('label'=>'Create EmployeeIncentives', 'url'=>array('create')),
	array('label'=>'Manage EmployeeIncentives', 'url'=>array('admin')),
);
?>

<h1>Employee Incentives</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
