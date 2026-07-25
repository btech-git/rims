<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $model EmployeeExchangeDayoff */

$this->breadcrumbs=array(
	'Employee Exchange Dayoffs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeExchangeDayoff', 'url'=>array('index')),
	array('label'=>'Create EmployeeExchangeDayoff', 'url'=>array('create')),
	array('label'=>'View EmployeeExchangeDayoff', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage EmployeeExchangeDayoff', 'url'=>array('admin')),
);
?>

<h1>Update EmployeeExchangeDayoff <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array(
    'model'=>$model,
    'dayOffOldList' => $dayOffOldList,
)); ?>