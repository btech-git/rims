<?php
/* @var $this EmployeeBankController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Banks',
);

$this->menu=array(
	array('label'=>'Create EmployeeBank', 'url'=>array('create')),
	array('label'=>'Manage EmployeeBank', 'url'=>array('admin')),
);
?>

<h1>Employee Banks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
