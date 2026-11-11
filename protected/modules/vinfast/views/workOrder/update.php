<?php
/* @var $this WorkOrderController */
/* @var $model WorkOrder */

$this->breadcrumbs=array(
	'Work Orders'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WorkOrder', 'url'=>array('index')),
	array('label'=>'Create WorkOrder', 'url'=>array('create')),
	array('label'=>'View WorkOrder', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WorkOrder', 'url'=>array('admin')),
);
?>

<h1>Update WorkOrder <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>