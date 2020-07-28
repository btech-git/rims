<?php
/* @var $this EquipmentMaintenanceController */
/* @var $model EquipmentMaintenance */

$this->breadcrumbs=array(
	'Equipment Maintenances'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List EquipmentMaintenance', 'url'=>array('index')),
	array('label'=>'Create EquipmentMaintenance', 'url'=>array('create')),
	array('label'=>'Update EquipmentMaintenance', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentMaintenance', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentMaintenance', 'url'=>array('admin')),
);
?>

<h1>View EquipmentMaintenance #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'equipment_id',
		'equipment_task_id',
		'equipment_branch_id',
		'employee_id',
		'maintenance_date',
		'next_maintenance_date',
	),
)); ?>
