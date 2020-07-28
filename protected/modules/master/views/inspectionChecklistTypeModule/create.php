<?php
/* @var $this InspectionChecklistTypeModuleController */
/* @var $model InspectionChecklistTypeModule */

$this->breadcrumbs=array(
	'Inspection Checklist Type Modules'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InspectionChecklistTypeModule', 'url'=>array('index')),
	array('label'=>'Manage InspectionChecklistTypeModule', 'url'=>array('admin')),
);
?>

<h1>Create InspectionChecklistTypeModule</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>