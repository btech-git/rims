<?php
/* @var $this ServiceEquipmentController */
/* @var $model ServiceEquipment */

$this->breadcrumbs=array(
	'Service Equipments'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServiceEquipment', 'url'=>array('index')),
	array('label'=>'Create ServiceEquipment', 'url'=>array('create')),
	array('label'=>'Update ServiceEquipment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServiceEquipment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServiceEquipment', 'url'=>array('admin')),
);
?>

<h1>View ServiceEquipment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'service_id',
		'equipment_id',
	),
)); ?>
