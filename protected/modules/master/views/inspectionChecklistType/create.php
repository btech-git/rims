<?php
/* @var $this InspectionChecklistTypeController */
/* @var $model InspectionChecklistType */

$this->breadcrumbs=array(
	'Service',
	'Inspection Checklist Types'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List InspectionChecklistType', 'url'=>array('index')),
	array('label'=>'Manage InspectionChecklistType', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'checklistType'=>$checklistType,
		'checklistModule'=>$checklistModule,
		'checklistModuleDataProvider'=>$checklistModuleDataProvider,
		'checklistModuleArray'=>$checklistModuleArray,)); 
	?>
</div>