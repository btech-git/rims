<?php
/* @var $this EquipmentTaskController */
/* @var $model EquipmentTask */

$this->breadcrumbs=array(
	'Equipment Tasks'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EquipmentTask', 'url'=>array('index')),
	array('label'=>'Create EquipmentTask', 'url'=>array('create')),
	array('label'=>'Update EquipmentTask', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentTask', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentTask', 'url'=>array('admin')),
);
?>

<h1>View EquipmentTask #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'equipment_id',
		'task',
		'check_period',
	),
)); ?>
