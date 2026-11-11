<?php
/* @var $this WorkOrderController */
/* @var $model WorkOrder */

$this->breadcrumbs=array(
	'Work Orders'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WorkOrder', 'url'=>array('index')),
	array('label'=>'Manage WorkOrder', 'url'=>array('admin')),
);
?>

<h1>Create WorkOrder</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>