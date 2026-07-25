<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $model EmployeeExchangeDayoff */

$this->breadcrumbs=array(
	'Employee Exchange Dayoffs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeExchangeDayoff', 'url'=>array('index')),
	array('label'=>'Manage EmployeeExchangeDayoff', 'url'=>array('admin')),
);
?>

<h1>Create EmployeeExchangeDayoff</h1>

<?php $this->renderPartial('_form', array(
    'model'=>$model, 
    'dayOffOldList' => $dayOffOldList,
)); ?>