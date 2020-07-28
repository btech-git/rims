<?php
/* @var $this InspectionController */
/* @var $model Inspection */

$this->breadcrumbs=array(
	'Service',
	'Inspections'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Inspection', 'url'=>array('index')),
	array('label'=>'Manage Inspection', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array(
		'inspection'=>$inspection,
		'section'=>$section,
		'sectionDataProvider'=>$sectionDataProvider,
		'sectionArray'=>$sectionArray,
	));?>
</div>