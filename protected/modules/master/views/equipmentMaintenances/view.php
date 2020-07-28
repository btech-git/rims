<?php
/* @var $this EquipmentMaintenancesController */
/* @var $model EquipmentMaintenances */

$this->breadcrumbs=array(
	'Equipment Maintenances'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EquipmentMaintenances', 'url'=>array('index')),
	array('label'=>'Create EquipmentMaintenances', 'url'=>array('create')),
	array('label'=>'Update EquipmentMaintenances', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentMaintenances', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentMaintenances', 'url'=>array('admin')),
);
?>

<h1>View EquipmentMaintenances #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'equipment_id',
		'equipment_task_id',
		'equipment_detail_id',
		'employee_id',
		'maintenance_date',
		'next_maintenance_date',
		'check_date',
		'checked',
		'notes',
		'equipment_condition',
		'status',
	),
)); ?>
