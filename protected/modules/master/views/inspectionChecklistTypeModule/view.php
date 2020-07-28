<?php
/* @var $this InspectionChecklistTypeModuleController */
/* @var $model InspectionChecklistTypeModule */

$this->breadcrumbs=array(
	'Inspection Checklist Type Modules'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InspectionChecklistTypeModule', 'url'=>array('index')),
	array('label'=>'Create InspectionChecklistTypeModule', 'url'=>array('create')),
	array('label'=>'Update InspectionChecklistTypeModule', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InspectionChecklistTypeModule', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InspectionChecklistTypeModule', 'url'=>array('admin')),
);
?>

<h1>View InspectionChecklistTypeModule #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'inspection_type_id',
		'inspection_module_id',
	),
)); ?>
