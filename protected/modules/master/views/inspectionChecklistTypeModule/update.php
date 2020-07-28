<?php
/* @var $this InspectionChecklistTypeModuleController */
/* @var $model InspectionChecklistTypeModule */

$this->breadcrumbs=array(
	'Inspection Checklist Type Modules'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InspectionChecklistTypeModule', 'url'=>array('index')),
	array('label'=>'Create InspectionChecklistTypeModule', 'url'=>array('create')),
	array('label'=>'View InspectionChecklistTypeModule', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InspectionChecklistTypeModule', 'url'=>array('admin')),
);
?>

<h1>Update InspectionChecklistTypeModule <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>