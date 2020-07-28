<?php
/* @var $this InspectionChecklistTypeController */
/* @var $model InspectionChecklistType */

$this->breadcrumbs=array(
	'Service',
	'Inspection Checklist Types'=>array('admin'),
	'Update Inspection Checklist Types',
);

/*$this->menu=array(
	array('label'=>'List InspectionChecklistType', 'url'=>array('index')),
	array('label'=>'Create InspectionChecklistType', 'url'=>array('create')),
	array('label'=>'View InspectionChecklistType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage InspectionChecklistType', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'checklistType'=>$checklistType,
		'checklistModule'=>$checklistModule,
		'checklistModuleDataProvider'=>$checklistModuleDataProvider,
		'checklistModuleArray'=>$checklistModuleArray
	));?>
</div>